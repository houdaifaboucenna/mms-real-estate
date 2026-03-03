<?php

namespace App\Http\Requests;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can(PermissionEnum::EDIT_ARTICLES->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:posts,title,' . $this->post->id,
            'content' => 'required',
            'title_ar' => 'required|unique:posts,title_ar,' . $this->post->id,
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
}
