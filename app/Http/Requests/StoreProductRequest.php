<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ];

        // Only require images for new products (POST requests)
        if ($this->isMethod('POST')) {
            $rules['images'] = 'required|array|min:1';
            $rules['images.*'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            // Make images optional for updates (PUT/PATCH requests)
            $rules['images'] = 'nullable|array';
            $rules['images.*'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }
}
