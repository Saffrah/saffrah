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
        $result = $this->package_repository->store($request);

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


}
