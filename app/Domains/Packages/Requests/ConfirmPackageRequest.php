<?php

namespace App\Domains\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPackageRequest extends FormRequest
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
            'package_id'   => 'required|exists:packages,id',
            'start_date'   => 'required|date|after:today',
            'end_date'     => 'required|date|after:start_date',
            'no_of_guests' => 'required|numeric'
        ];
    }
}
