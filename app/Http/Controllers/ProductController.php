<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ProductResource::collection(Product::latest()->paginate(12));
        return Inertia::render('Products/Index', ['products' => $products]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => ProductResource::make($product)
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
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
        ]);

        // Handle image uploads if necessary
        if ($request->hasFile('images')) {
            $firstImage = true;
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/' . $product->id, 's3');
                $product->images()->create([
                    'image_path' => $path
                ]);

                // Set the first image as primary
                if ($firstImage) {
                    $product->update(['primary_image' => $path]);
                    $firstImage = false;
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
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
