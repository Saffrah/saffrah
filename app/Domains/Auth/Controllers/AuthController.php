<?php

namespace App\Domains\Auth\Controllers;

// Requests

use App\Domains\Auth\Requests\AuthLoginRequest;
use App\Domains\Auth\Requests\AuthRegisterRequest;

// Services
use App\Domains\Auth\Services\AuthService;

// Liberaries
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private $auth_service;

    public function __construct(AuthService $auth_service) 
    {
        $this->auth_service = $auth_service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(AuthRegisterRequest $request)
    {
        $result = $this->auth_service->register($request->validated());
        
        return response()->json($result);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AuthLoginRequest $request)
    {
        $result = $this->auth_service->login($request->validated());

        return response()->json($result);
    }


}
