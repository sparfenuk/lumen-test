<?php

namespace App\Http\Requests\Auth;

use Anik\Form\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'email' => 'required|email|max:255|exists:users',
            'password' => 'required|min:8|max:100',
        ];
    }
}
