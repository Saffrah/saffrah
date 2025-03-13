<?php

namespace App\Domains\FileManager\Requests;

use App\Http\Requests\RequestValidatorResponse;

class StoreFileRequest extends RequestValidatorResponse
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
            'files.*'    => 'file|max:2048|mimes:jpg,jpeg,png,csv,xlsx,xls,doc,docx,pdf',
            'model_id'   => 'required|numeric',
            'model_type' => 'required|string|in:company,package,user',
            'package_id' => 'required_if:model_type,user|numeric'
        ];
    }
  
}
