<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'unique:discount_codes', 'max:40'],
            'percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'valid_until' => ['required', 'date', 'after:today'],
            'is_active' => ['boolean', 'default:true'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
