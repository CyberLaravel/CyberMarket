<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        return Inertia::render('Reviews/Index', [
            'product' => $product->load('reviews.user'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest  $request)
    {
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
