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
            'shipping_details.full_name' => 'required|string|max:255',
            'shipping_details.email' => 'required|email|max:255',
            'shipping_details.phone' => 'required|string|max:20',
            'shipping_details.address' => 'required|string|max:255',
            'shipping_details.city' => 'required|string|max:255',
            'shipping_details.state' => 'required|string|max:255',
            'shipping_details.postal_code' => 'required|string|max:20',
            'shipping_details.country' => 'required|string|max:255',
            'cart_items' => 'required|array|min:1',
            'cart_items.*.id' => 'required|exists:products,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ];
    }
}
