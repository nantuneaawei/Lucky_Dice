<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6|max:30',
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => '必須使用正確的信箱',
            'password.min' => '密碼必須大於6個字',
            'password.max' => '密碼必須小於30個字',
        ];
    }
}
