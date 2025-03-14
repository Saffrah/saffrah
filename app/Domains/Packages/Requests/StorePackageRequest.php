<?php

namespace App\Domains\Packages\Requests;

use App\Http\Requests\RequestValidatorResponse;

class StorePackageRequest extends RequestValidatorResponse
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
            'user_id'          => 'nullable|exists:users,id',
            'offer_id'         => 'required_with:user_id|exists:offers,id',
            'name'             => 'required|string|max:250',
            'name_ar'          => 'required|string|max:250',
            'from_city'        => 'required|numeric|exists:cities,id',
            'to_city'          => 'required|numeric|exists:cities,id',
            'no_of_nights'     => 'required|numeric|min:1',
            'price_per_person' => 'required|numeric|min:1',
            'hotel_name'       => 'required|string|max:250',
            'hotel_name_ar'    => 'required|string|max:250',
            'reservation_type' => 'numeric|in:1,2,3',
            'is_cruise'        => 'boolean',
            'end_date'         => 'required|date_format:Y-m-d',
            'description'      => 'string',
            'description_ar'   => 'string',
            'transits'         => 'array',
            'transits.*.to_city'        => 'required|numeric|exists:cities,id',
            'transits.*.no_of_nights'   => 'required|numeric|min:1',
            'transits.*.hotel_name'     => 'required|string|max:250',
            'transits.*.hotel_name_ar'  => 'required|string|max:250',
            'transits.*.description'    => 'string',
            'transits.*.description_ar' => 'string',
        ];
    }
}
