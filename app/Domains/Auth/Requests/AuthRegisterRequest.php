<?php

namespace App\Domains\Auth\Requests;

use App\Domains\Auth\Rules\EmailUniqueRule;
use App\Domains\Auth\Rules\PhoneNumberUniqueRule;
use App\Http\Requests\RequestValidatorResponse;
use Illuminate\Validation\Rules\Password;

class AuthRegisterRequest extends RequestValidatorResponse
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
            'name'              => 'required|string|max:250',
            'email'             => ['required', 'email', new EmailUniqueRule],
            'user_type'         => 'required|string|in:user,company',
            'commercial_number' => 'required_if:user_type,company',
            'tax_number'        => 'required_if:user_type,company',
            'phone_number'      => ['required', 'string', 'min:10', new PhoneNumberUniqueRule],
            'password'          => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()] 
        ];
    }
}
