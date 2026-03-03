<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'telegram' => ['nullable', 'url', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'desc' => ['nullable', 'string', 'max:1000'],
            'desc_ar' => ['nullable', 'string', 'max:1000'],
            'keywords' => ['nullable', 'string', 'max:500'],
            'keywords_ar' => ['nullable', 'string', 'max:500'],
            'home_imgs' => ['nullable', 'array'],
            'home_imgs.*' => ['image', 'max:2048'],
        ];
    }
}
