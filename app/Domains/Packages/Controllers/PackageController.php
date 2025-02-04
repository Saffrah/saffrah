<?php

namespace App\Domains\Packages\Controllers;

// Services
use App\Domains\Packages\Services\PackageService;

// Requests
use App\Domains\Packages\Requests\PackageRequest;
use App\Domains\Packages\Requests\AllPackagesRequest;
use App\Domains\Packages\Requests\StorePackageRequest;
use App\Domains\Packages\Requests\UpdatePackageRequest;
use App\Domains\Packages\Requests\ConfirmPackageRequest;

// Liberaries
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    private $package_service;

    public function __construct(PackageService $package_service) 
    {
        $this->package_service = $package_service;
    }

    /**
     * retrieve resources from storage.
     */
    public function destinations()
    {
        $result = $this->package_service->cities_list();
        
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $result = $this->package_service->store($request->validated());
        
        return response()->json($result);
    }

    public function get_package($id) 
    {
        $result = $this->package_service->get_by_id($id);

        return response()->json($result);
    }

    public function get_company_packages()
    {
        $result = $this->package_service->get_company_packages();

        return response()->json($result);
    }

    public function all_packages(AllPackagesRequest $request) 
    {
        $result = $this->package_service->get_all_packages($request->validated());

        return response()->json($result);
    }

    public function edit(UpdatePackageRequest $request) 
    {
        $result = $this->package_service->edit($request->validated());
        
        return response()->json($result);
    }

    public function delete(PackageRequest $request) 
    {
        $result = $this->package_service->delete($request->package_id);
        
        return response()->json($result);
    }

    public function confirmPackage(ConfirmPackageRequest $request) 
    {
        $result = $this->package_service->confirm($request->validated());
        
        return response()->json($result);
    }

    function packageDeals() 
    {
        $result = $this->package_service->getDeals();

        return response()->json($result);
    }


}
