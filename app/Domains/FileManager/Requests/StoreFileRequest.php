<?php

namespace App\Domains\FileManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'files'      => 'required|array',
            'files.*'    => 'file|max:2048|mimes:jpg,png,csv,xlsx,xls,doc,docx,pdf',
            'model_type' => 'required|string|in:company,package',
            'model_id'   => 'required_if:model_type,package|numeric'
        ];
    }

    
}
