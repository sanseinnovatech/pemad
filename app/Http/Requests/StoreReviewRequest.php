<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'rating'  => ['required','integer','min:1','max:5'],
            'title'   => ['required','string','min:3','max:100'],
            'content' => ['required','string','min:5','max:1000'],
        ];
    }
}
