<?php

namespace App\Http\Services;

use App\Domains\Packages\Repositories\PackageRepository AS DomainPackageRepository;
use App\Http\Repositories\PackageRepository;

class PackageService
{
    private $domain_package_repository;
    private $package_repository;

    public function __construct(PackageRepository $package_repository = null, DomainPackageRepository $domain_package_repository) 
    {
        $this->domain_package_repository = $domain_package_repository;
        $this->package_repository        = $package_repository;
    }

    public function get_all() 
    {
        return $this->package_repository->all();    
    }

    public function get_deals() 
    {
        return $this->package_repository->deals();    
    }

    public function updateStatus($input) 
    {
        if($input['new_status'] == "verify")
            return $this->package_repository->update($input['package_id'], ['email_verified_at' => now()]);
        else
            return $this->package_repository->update($input['package_id'], ['email_verified_at' => null]);
    }

    public function delete($request) 
    {
        return $this->package_repository->delete($request['package_id']);
    }

}
