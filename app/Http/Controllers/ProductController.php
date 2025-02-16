<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with('seller:id,name,email')->with('primaryImage');

        // Apply search filter
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhereHas('seller', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Apply category filter
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        // Apply sorting
        switch ($request->input('sort', 'newest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }


        return Inertia::render('Products/Index', [
            'products' => $query->paginate(10),
            'filters' => $request->only(['search', 'sort', 'category']),
            'categories' => Category::all(),
        ]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => ProductResource::make($product->load(['images', 'seller', 'primaryImage'])),
            'isSeller' =>  $product->user_id === Auth::id()
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // Create the product
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'slug' => $request->slug,
        ]);

        // Handle image uploads if necessary
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/' . $product->id, 's3');
                $productImage = $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => (int)$index === (int)$request->primary_image_index
                ]);

                // Set primary_image_id if this is the primary image
                if ((int)$index === (int)$request->primary_image_index) {
                    $product->update(['primary_image_id' => $productImage->id]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => ProductResource::make($product->load(['images', 'seller', 'primaryImage'])),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);

        // Update basic product information
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        // Handle new image uploads if necessary
        if ($request->hasFile('images')) {
            $newImages = [];

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/' . $product->id, 's3');
                $newImage = $product->images()->create([
                    'image_path' => $path
                ]);

                $newImages[] = $newImage;

                // If this is the selected primary image from new uploads
                if ($request->new_primary_image_index === $index) {
                    $product->update([
                        'primary_image_id' => $newImage->id
                    ]);
                }
            }
        }

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
