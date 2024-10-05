<?php

namespace App\Domains\Packages\Repositories;

use App\Models\City;
use App\Models\Country;
use App\Models\Package;

class PackageRepository
{
    private $model;
    private $city_model;
    private $country_model;

    public function __construct(
        City    $city_model,
        Package $model,
        Country $country_model
    )
    {
        $this->model         = $model;
        $this->city_model    = $city_model;
        $this->country_model = $country_model;
    }

    public function get_cities() 
    {
        return $this->city_model->join('countries', 'countries.id', 'cities.country_id')
                                ->select(
                                    'cities.id', 'cities.name', 'cities.country_code',
                                    'countries.name AS country_name', 'countries.iso3'
                                )
                                ->groupBy('cities.id')
                                ->get()
                                ->groupBy('country_name');
    }

    public function store($request) 
    {
        return $this->model->create($request);
    }

    
}
