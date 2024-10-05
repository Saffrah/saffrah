<?php

namespace App\Domains\Packages\Controllers;

// Services
use App\Domains\Packages\Services\PackageService;

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
    public function store( $request)
    {
        $result = $this->package_service->store($request->validated());
        
        return response()->json($result);
    }


}
