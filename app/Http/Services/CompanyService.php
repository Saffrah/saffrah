<?php

namespace App\Http\Services;

use App\Domains\Packages\Repositories\PackageRepository;
use App\Http\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;

class CompanyService
{
    private $company_repository;
    private $package_repository;

    public function __construct(CompanyRepository $company_repository = null, PackageRepository $package_repository) 
    {
        $this->company_repository = $company_repository;
        $this->package_repository = $package_repository;
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

    public function delete($request) 
    {
        $packages = $this->package_repository->deleteAllByCompany($request['company_id']);
        if($packages)
            return $this->company_repository->delete($request['company_id']);

        return false;
    }

}
