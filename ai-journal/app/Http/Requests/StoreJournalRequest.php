<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJournalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isJournalEditor() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'issn' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:2000'],
            'subject_area' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
