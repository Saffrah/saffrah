<?php

namespace App\Domains\Packages\Repositories;

use App\Models\City;
use App\Models\Country;
use App\Models\Package;
use App\Models\Transit;

class PackageRepository
{
    private $model;
    private $city_model;
    private $country_model;
    private $transit_model;

    public function __construct(
        Country $country_model,
        City    $city_model,
        Package $model,
        Transit $transit_model
    )
    {
        $this->model         = $model;
        $this->city_model    = $city_model;
        $this->country_model = $country_model;
        $this->transit_model = $transit_model;
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

    public function add_transit($package_id, $request) 
    {
        $stored = true;

        foreach ($request as $key => $transit) {
            $transit['package_id'] = $package_id;
            $stored = $this->transit_model->create($transit);

            if(!$stored)
                break;
        }

        return $stored;
    }

    public function by_id($id) 
    {
        return $this->model->find($id)->with(['Transits', 'Transits.to_city', 'from_city', 'to_city'])->first();   
    }

    public function all() 
    {
        return $this->model->with(['Transits', 'Transits.to_city', 'from_city', 'to_city'])->get();   
    }

    
}