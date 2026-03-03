<?php

namespace App\Http\Requests;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class EstateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionEnum::CREATE_ESTATES->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:estates',
            'content' => 'required',
            'title_ar' => 'required|unique:estates',
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'type' => 'required',
            'min' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'town_id' => 'required',
            'slug' => 'required|unique:estates',
            'images' => 'nullable|array',
        ];
    }
}
