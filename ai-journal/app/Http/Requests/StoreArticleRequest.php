<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'journal_id' => ['required', 'exists:journals,id'],
            'title' => ['required', 'string', 'max:500'],
            'abstract' => ['required', 'string', 'min:50'],
            'content' => ['required', 'string', 'min:200'],
            'keywords' => ['nullable', 'string', 'max:500'],
        ];
    }
}
