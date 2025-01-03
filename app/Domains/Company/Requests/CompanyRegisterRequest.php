<?php

namespace App\Domains\Company\Requests;

use App\Http\Requests\RequestValidatorResponse;
use Illuminate\Validation\Rules\Password;

class CompanyRegisterRequest extends RequestValidatorResponse
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
            'email'        => 'required|email|unique:companies,email',
            'phone_number' => 'required|string|min:11',
            'password'     => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()] 
        ];
    }
}
