<?php

namespace App\Domains\Offers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'from_city'          => 'required|numeric|exists:cities,id',
            'to_city'            => 'required|numeric|exists:cities,id',
            'no_of_nights'       => 'required|numeric|min:1',
            'no_of_adults'       => 'required|numeric|min:1',
            'no_of_children'     => 'required|numeric|min:0',
            'start_date'         => 'required|date|after:today',
            'end_date'           => 'required|date|after:start_date',
            'max_price'          => 'required|numeric|min:1',
            'including_tickets'  => 'boolean',
            'including_hotels'   => 'boolean',
            'including_program'  => 'boolean',
            'reservation_type'   => 'numeric|in:1,2,3',
            'note'               => 'string',
            'transits'           => 'array',
            'transits.*.to_city'        => 'required|numeric|exists:cities,id',
            'transits.*.no_of_nights'   => 'required|numeric|min:1',
            'transits.*.note'           => 'string',
        ];
    }
}
