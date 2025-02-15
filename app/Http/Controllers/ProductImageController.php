<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $productImage)
    {
        // Delete the file from storage
        if ($productImage->image_path) {
            Storage::disk('s3')->delete($productImage->image_path);
        }

        // Delete the database record
        $productImage->delete();

        return redirect()->back();
    }

    public function setPrimary(ProductImage $productImage)
    {
        // Remove primary status from all other images of this product
        ProductImage::where('product_id', $productImage->product_id)
            ->update(['is_primary' => false]);

        // Set this image as primary
        $productImage->update(['is_primary' => true]);

        return redirect()->back();
    }
}
