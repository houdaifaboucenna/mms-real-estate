<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqUpdateRequest extends FormRequest
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
            'question' => 'required|unique:faqs,question,' . $this->faq->id,
            'question_ar' => 'required|unique:faqs,question_ar,' . $this->faq->id,
            'answer' => 'required',
            'answer_ar' => 'required',
            'show_home' => 'required|boolean',
        ];
    }
}
