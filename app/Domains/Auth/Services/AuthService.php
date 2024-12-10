<?php

namespace App\Domains\Auth\Services;

// Repositories
use App\Domains\Auth\Repositories\AuthRepository;
use App\Domains\Company\Repositories\CompanyRepository;
use App\Domains\FileManager\Repositories\FileManagerRepository;
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
    private $file_manager_repository;

    public function __construct(
        AuthRepository $auth_repository, 
        CompanyRepository $company_repository,
        FileManagerRepository $file_manager_repository
    ) 
    {
        $this->auth_repository         = $auth_repository;
        $this->company_repository      = $company_repository;
        $this->file_manager_repository = $file_manager_repository;
    }

    public function register($request) 
    {
        if($request['user_type'] == 'user') {
            $result = $this->auth_repository->register($request);
            $result['token']    = $result->createToken('User', ['role:user'])->plainTextToken; 
            $result['interest'] = "user_int_00".$result['id'];
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

    protected function create_credentials($request, $user) 
    {
        if(Hash::check($request['password'], $user->password)) {
            $type = $user instanceof User ? 'user' : 'company';
            $user->tokens()->delete();
            $user['token']     = $user->createToken($type, ['role:'.$type])->plainTextToken; 
            $user['user_type'] = $type;
            if($type == 'company' && $user->email_verified_at == NULL) {
                return [
                    'response_code'    => 403,
                    'response_message' => 'You are not verified yet, please contact the administration !',
                    'response_data'    => $user
                ];
            }
            return [
                'response_code'    => 200,
                'response_message' => 'Logged In Successfully',
                'response_data'    => $user
            ];
        }
        else {            
            return [
                'response_code'    => 400,
                'response_message' => 'The email or Password are not correct !',
                'response_data'    => NULL
            ];
        }
    }

    function login($request) 
    {
        $user = User::where('email', $request['email'])->orWhere('phone_number', $request['email'])->first();

        if($user) { 
            $result = $this->create_credentials($request, $user);
        }
        else {
            $user   = Company::where('email', $request['email'])->orWhere('phone_number', $request['email'])->first();
            if($user) {
                $result = $this->create_credentials($request, $user);

                if($result['response_code'] == 403) {
                    $registration_files = $this->file_manager_repository->getAllRegistrationFiles($user->id);
                    if($registration_files->isEmpty()) {
                        $result['response_code']    = 300;
                        $result['response_message'] = 'Please upload the needed Company verification files in order for administration to proceed with your application.';
                    }
                }
            }
            else {
                $result = [
                    'response_code'    => 400,
                    'response_message' => 'These Credentials are not correct !',
                    'response_data'    => NULL
                ];
            }
        }

        return $result;     
    }


}
