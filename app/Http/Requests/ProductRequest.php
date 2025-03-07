<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'pending' => $this->boolean('pending'),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'shipment' => ['required', 'boolean'],
            'img_path' => ['required', 'array'],
            'img_path.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'pending' => ['required', 'boolean'],
        ];
    }
}
