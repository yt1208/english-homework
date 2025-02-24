<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostGrammarChatGPTRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
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
            'answer' => 'required|in:1,2,3,4',
        ];
    }

    public function messages()
    {
        return [
            'answer.required' => '回答は必須です。',
            'answer.in' => '回答は1～4の選択肢から選んでください。',
        ];
    }
}
