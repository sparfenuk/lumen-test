<?php

namespace App\Http\Requests\Auth;

use Anik\Form\FormRequest;

class RecoverPasswordRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'email.exists' => 'Please enter a correct email'
        ];
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
        ];
    }
}
