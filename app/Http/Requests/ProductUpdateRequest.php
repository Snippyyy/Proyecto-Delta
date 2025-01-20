<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'shipment' => ['required', 'boolean'],
            'img_path' => ['nullable', 'array'],
            'img_path.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'images_to_delete' => ['nullable', 'array'],
            'images_to_delete.*' => ['exists:product_images,id'],
            'image_delete_confirmation' => ['nullable', 'boolean'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
