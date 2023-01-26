<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'mimes:jpeg,jpg,png', 'max:5000'],
            'title' => ['required'],
            'author' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
        ];
    }
}
