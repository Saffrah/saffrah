<?php

namespace App\Domains\Company\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyLoginRequest extends FormRequest
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
            'email'    => 'required|email|exists:companies,email',
            'password' => 'required'
        ];
    }
}
