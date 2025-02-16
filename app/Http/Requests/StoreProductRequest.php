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
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|string|max:255|unique:products,slug',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image_index' => 'required|integer|min:0',
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

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category',
            'category_id.exists' => 'The selected category is invalid',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('images') && $this->has('primary_image_index')) {
                if ($this->primary_image_index >= count($this->file('images'))) {
                    $validator->errors()->add('primary_image_index', 'The primary image index is invalid.');
                }
            }
        });
    }
}
