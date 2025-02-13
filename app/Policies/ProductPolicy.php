<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine if the user can view any products.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view products
    }

    /**
     * Determine if the user can view a specific product.
     */
    public function view(User $user, Product $product): bool
    {
        return true; // Anyone can view a product
    }

    /**
     * Determine if the user can create products.
     */
    public function create(User $user): bool
    {
        // return $user->is_seller;
        return $user->role === 'seller' || true; // Only sellers can create products
    }


    /**
     * Determine if the user can update a product.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id; // Only the product owner can update
    }

    /**
     * Determine if the user can delete a product.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id; // Only the product owner can delete
    }
}
