<?php

namespace App\Domains\Auth\Requests;

use App\Domains\Auth\Rules\EmailOrPhoneRule;
use App\Http\Requests\RequestValidatorResponse;

class AuthLoginRequest extends RequestValidatorResponse
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
            'email'    => ['required', new EmailOrPhoneRule],
            'password' => 'required'
        ];
    }
}
