<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstateUpdateRequest extends FormRequest
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
            'title' => 'required|unique:estates,title,' . $this->estate->id,
            'content' => 'required',
            'title_ar' => 'required|unique:estates,title_ar,' . $this->estate->id,
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'type' => 'required',
            'min' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'town_id' => 'required',
            'slug' => 'required|unique:estates,slug,' . $this->estate->id,
            'images' => 'nullable|array',
        ];
    }
}
