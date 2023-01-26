<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['mimes:jpeg,jpg,png', 'max:5000'],
        ];
    }
}
