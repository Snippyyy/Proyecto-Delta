<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255|min:5',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
