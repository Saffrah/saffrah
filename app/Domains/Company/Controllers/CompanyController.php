<?php

namespace App\Domains\Company\Controllers;

// Requests

use App\Domains\Company\Requests\CompanyLoginRequest;
use App\Domains\Company\Requests\CompanyRegisterRequest;

// Services
use App\Domains\Company\Services\CompanyService;

// Liberaries
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    private $company_service;

    public function __construct(CompanyService $company_service) 
    {
        $this->company_service = $company_service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(CompanyRegisterRequest $request)
    {
        $result = $this->company_service->register($request->validated());
        
        return response()->json($result);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(CompanyLoginRequest $request)
    {
        $result = $this->company_service->login($request->validated());

        return response()->json($result);
    }

    function companyDeals() 
    {
        $result = $this->company_service->getDeals();

        return response()->json($result);
    }

}
