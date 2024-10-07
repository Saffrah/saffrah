<?php

namespace App\Domains\Packages\Services;

use App\Domains\Packages\Repositories\PackageRepository;

class PackageService
{
    private $package_repository;

    public function __construct(PackageRepository $package_repository ) 
    {
        $this->package_repository = $package_repository;
    }

    public function cities_list() 
    {
        $cities = $this->package_repository->get_cities();

        if($cities) {
            return [
                'response_code'    => 200,
                'response_message' => 'Cities Retrieved successfully !', 
                'response_data'    => $cities->toArray()
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'Cities retrieve failed !', 
            'response_data'    => NULL
        ];
    }

    public function store($request) 
    {
        $package = $this->package_repository->store($request);
        
        if($package) { 
            $transits = $this->package_repository->add_transit($package->id, $request['transits']);
        }

        if($package && $transits) {
            return [
                'response_code'    => 200,
                'response_message' => 'registered successfully !', 
                'response_data'    => $this->package_repository->by_id($package->id)
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'registered failed !', 
            'response_data'    => []
        ];
    }

    public function get_by_id($id) 
    {
        $results = $this->package_repository->by_id($id);
        
        if($results) {
            return [
                'response_code'    => 200,
                'response_message' => 'Package fitched successfully !', 
                'response_data'    => $results
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'fitching failed !', 
            'response_data'    => []
        ];
    }

    public function get_all_packages() 
    {
        $results = $this->package_repository->all();
        
        if($results) {
            return [
                'response_code'    => 200,
                'response_message' => 'Packages fitched successfully !', 
                'response_data'    => $results
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'fitching failed !', 
            'response_data'    => []
        ];
    }


}
