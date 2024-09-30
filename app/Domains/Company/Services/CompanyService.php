<?php

namespace App\Domains\Company\Services;

use App\Domains\Company\Repositories\CompanyRepository;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CompanyService
{
    private $company_repository;

    public function __construct(CompanyRepository $company_repository ) 
    {
        $this->company_repository = $company_repository;
    }

    public function register($request) 
    {
        $result = $this->company_repository->register($request);

        if($result) {
            return [
                'response_code'    => 200,
                'response_message' => 'registered successfully !', 
                'response_data'    => $result
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'registered failed !', 
            'response_data'    => []
        ];
    }

    function login($request) 
    {
        $company = Company::where('email', $request['email'])->first();

        if (!$company || !Hash::check($request['password'], $company->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        else { 
            $company['token'] =  $company->createToken('Company', ['role:company'])->plainTextToken; 
   
            return [
                'response_code'    => 200,
                'response_message' => 'Logged In Successfully',
                'response_data'    => $company
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'LogIn Credentials are not correct !',
            'response_data'    => []
        ];     
    }


}
