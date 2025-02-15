<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'items.required' => 'Cart items are required',
            'items.*.id.required' => 'Product ID is required',
            'items.*.id.exists' => 'Invalid product selected',
            'items.*.quantity.required' => 'Product quantity is required',
            'items.*.quantity.integer' => 'Quantity must be a number',
            'items.*.quantity.min' => 'Quantity must be at least 1',
        ];
    }
}
