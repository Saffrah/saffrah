<?php

namespace App\Domains\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthRegisterRequest extends FormRequest
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
            'name'         => 'required|string|max:250',
            'email'        => 'required|email',
            'user_type'    => 'required|string|in:user,company',
            'phone_number' => 'required|string|min:11',
            'password'     => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()] 
        ];
    }
}
