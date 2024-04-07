<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|max:30',
            'email' => 'required|unique:players,email',
            'password' => 'required|min:6|max:30',
        ];
    }

    public function messages(): array
    {
        return [
            'username.max' => '名稱必須小於30個字',
            'email.unique' => '信箱已被使用',
            'password.min' => '密碼必須大於6個字',
            'password.max' => '密碼必須小於30個字',
        ];
    }
}
