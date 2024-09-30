<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    private $auth_repository;

    public function __construct(AuthRepository $auth_repository ) 
    {
        $this->auth_repository = $auth_repository;
    }

    public function register($request) 
    {
        $result = $this->auth_repository->register($request);

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
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) { 
            /** @var \App\Models\User $user **/
            $user = auth('sanctum')->user(); 
            $user['token'] =  $user->createToken('User', ['role:user'])->plainTextToken; 
   
            return [
                'response_code'    => 200,
                'response_message' => 'Logged In Successfully',
                'response_data'    => $user
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'LogIn Credentials are not correct !',
            'response_data'    => []
        ];     
    }


}
