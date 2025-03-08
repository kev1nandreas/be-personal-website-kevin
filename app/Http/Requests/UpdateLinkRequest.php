<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'unique:links,slug,', 'regex:/^[a-zA-Z0-9-_]+$/'],
            'destination' => ['required', 'url'],
            'expires_at' => ['nullable', 'date'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
