<?php

namespace App\Domains\Packages\Repositories;

use App\Domains\FileManager\Models\FileManager;
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
    private $file_manager_model;

    public function __construct(
        FileManager $file_manager_model,
        Country     $country_model,
        City        $city_model,
        Package     $model,
        Transit     $transit_model,
    )
    {
        $this->model              = $model;
        $this->city_model         = $city_model;
        $this->country_model      = $country_model;
        $this->transit_model      = $transit_model;
        $this->file_manager_model = $file_manager_model;
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
        return $this->model->where('id', $id)->with(['Transits', 'Transits.to_city', 'from_city', 'to_city', 'Files'])->first();   
    }

    public function get_one_by_company_id($company_id, $package_id) 
    {
        return $this->model->where('id', $package_id)->where('company_id', $company_id)->first();    
    }

    function by_company_id($id) 
    {
        return $this->model->where('company_id', $id)->with(['Transits', 'Transits.to_city', 'from_city', 'to_city', 'Files'])->get();    
    }

    public function all() 
    {
        return $this->model->with(['Transits', 'Transits.to_city', 'from_city', 'to_city', 'Files'])->get();   
    }

    public function update($request) 
    {
        return $this->model->updateOrCreate([
            'id'         => $request['package_id'],
            'company_id' => auth('sanctum')->user()->id, 
        ], $request);    
    }

    public function update_transits($package_id, $transits) 
    {
        $delete = $this->transit_model->where('package_id', $package_id)->delete();
        
        if($delete && $transits) {
            return $this->add_transit($package_id, $transits);
        }

        return false;
    }

    public function delete($id) 
    {
        $company = auth('sanctum')->user();

        $package = $this->model->where('company_id', $company->id)->where('id', $id)->first();
       
        if($package) {
            $transits = $this->transit_model->where('package_id', $id)->get();
            if($transits)
                $transits->each->delete();
    
            $files = $this->file_manager_model->where('model_type', 'package')->where('package_id', $id)->get();
            if($files)
                $files->each->delete();

            return $package->delete($id);    
        }

        return false;
    }

    
}
