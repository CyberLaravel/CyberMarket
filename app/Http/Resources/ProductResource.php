<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SellerResource;
use App\Http\Resources\ProductImageResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'seller' => SellerResource::make($this->whenLoaded('seller')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'primary_image' => $this->whenLoaded('primaryImage', function () {
                return $this->primaryImage?->image_path;
            }),
            'primary_image_id' => $this->whenLoaded('primaryImage', function () {
                return $this->primaryImage?->id;
            }),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at,
        ];
    }
}
