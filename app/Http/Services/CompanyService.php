<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;

class CompanyService
{
    private $company_repository;

    public function __construct(CompanyRepository $company_repository = null) 
    {
        $this->company_repository = $company_repository;
    }

    public function get_all() 
    {
        return $this->company_repository->all();    
    }

    public function updateStatus($input) 
    {
        if($input['new_status'] == "verify")
            return $this->company_repository->update($input['company_id'], ['email_verified_at' => now()]);
        else
            return $this->company_repository->update($input['company_id'], ['email_verified_at' => null]);
    }

}
