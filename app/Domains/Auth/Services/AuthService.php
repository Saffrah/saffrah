<?php

namespace App\Domains\Auth\Services;

// Repositories
use App\Domains\Auth\Repositories\AuthRepository;
use App\Domains\Company\Repositories\CompanyRepository;

// Models
use App\Models\Company;
use App\Models\User;
// Libraries
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $auth_repository;
    private $company_repository;

    public function __construct(AuthRepository $auth_repository, CompanyRepository $company_repository) 
    {
        $this->auth_repository = $auth_repository;
        $this->company_repository = $company_repository;
    }

    public function register($request) 
    {
        if($request['user_type'] == 'user') {
            $result = $this->auth_repository->register($request);
            $result['token'] = $result->createToken('User', ['role:user'])->plainTextToken; 

        }
        else {
            $result = $this->company_repository->register($request);
            $result['token'] = $result->createToken('Company', ['role:company'])->plainTextToken; 
        }

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
            'response_data'    => NULL
        ];
    }

    function login($request) 
    {
        $result  = false;
        $message = 'LogIn Credentials are not correct !';

        $user = User::where('email', $request['email'])->first();

        if($user) { 
            /** @var \App\Models\User $user **/
            $user              = auth('sanctum')->user(); 
            if(Hash::check($request['password'], $user->password) && $user->email_verified_at != NULL) {
                $user['token']     =  $user->createToken('User', ['role:user'])->plainTextToken; 
                $user['user_type'] = 'User';
                $result = true;
            }
            elseif(Hash::check($request['password'], $user->password) && $user->email_verified_at == NULL) {
                $message = 'You are not verified yet, please contact the administration !';
                $user->tokens()->delete();
            }
            
        }


        $user = Company::where('email', $request['email'])->first();
        if($user) {
            if (Hash::check($request['password'], $user->password) && $user->email_verified_at != NULL) {
                $user['token']     =  $user->createToken('Company', ['role:company'])->plainTextToken; 
                $user['user_type'] = 'Company';
                $result = true;
            }
            elseif(Hash::check($request['password'], $user->password) && $user->email_verified_at == NULL) {
                $message = 'You are not verified yet, please contact the administration !';
                $user->tokens()->delete();
            }

        }

        if($result) {
            return [
                'response_code'    => 200,
                'response_message' => 'Logged In Successfully',
                'response_data'    => $user
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => $message,
            'response_data'    => NULL
        ];     
    }


}
