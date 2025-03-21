<?php

namespace App\Domains\Packages\Repositories;

use App\Domains\FileManager\Models\FileManager;
use App\Models\City;
use App\Models\Country;
use App\Models\offerPackage;
use App\Models\Package;
use App\Models\PackageConfirm;
use App\Models\Transit;

class PackageRepository
{
    private $model;
    private $city_model;
    private $country_model;
    private $transit_model;
    private $file_manager_model;
    private $offer_package_model;
    private $package_confirm_model;

    public function __construct(
        PackageConfirm $package_confirm_model,
        offerPackage   $offer_package_model,
        FileManager    $file_manager_model,
        Transit        $transit_model,
        Country        $country_model,
        City           $city_model,
        Package        $model
    )
    {
        $this->model                 = $model;
        $this->city_model            = $city_model;
        $this->country_model         = $country_model;
        $this->transit_model         = $transit_model;
        $this->file_manager_model    = $file_manager_model;
        $this->offer_package_model   = $offer_package_model;
        $this->package_confirm_model = $package_confirm_model;
    }

    public function get_cities() 
    {
        return $this->country_model->select(
            'id', 'name', 'name_ar', 'iso3'
        )->with(['Cities:id,name,name_ar,country_id'])->get()->toArray();
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

    public function addToUserOffer($request) 
    {
        return $this->offer_package_model->create($request);
    }

    public function by_id($id) 
    {
        return $this->model->where('id', $id)->with(['Transits', 'Transits.To', 'From', 'To', 'Files'])->first();   
    }

    public function get_one_by_company_id($company_id, $package_id) 
    {
        return $this->model->where('id', $package_id)->where('company_id', $company_id)->first();    
    }

    function by_company_id($id) 
    {
        return $this->model->where('company_id', $id)->with(['Transits', 'Transits.To', 'From', 'To', 'Files'])->get();    
    }

    public function all($request) 
    {
        $query = $this->model->with(['Transits', 'Transits.To', 'From', 'To', 'Files']);
        
        if (isset($request['is_cruise'])) {
            $query->where('is_cruise', $request['is_cruise']);
        }

        return $query->get();   
    }

    public function get_by_country($request) 
    {
        $countries = $this->country_model->join('cities', 'cities.country_id', 'countries.id')
                                         ->join('packages', 'packages.to_city', 'cities.id')
                                         ->select('countries.*')
                                         ->groupBy('countries.id')
                                         ->get()
                                         ->toArray();
        foreach ($countries as $key => $country) 
        {
            $cities = $this->city_model->join('countries', 'countries.id', 'cities.country_id')
                                       ->join('packages', 'packages.to_city', 'cities.id')
                                       ->select('cities.*')
                                       ->with(['packages', 'packages.Company', 'packages.Transits', 'packages.From', 'packages.To', 'packages.Files', 'packages.Transits.To'])
                                       ->where('countries.id', $country['id'])
                                       ->whereNull('packages.user_id')
                                       ->whereNull('packages.deleted_at');

            if(isset($request['is_cruise'])) {
                $cities = $cities->where('packages.is_cruise', $request['is_cruise']);
            }
                                       
            if($cities) {
                $countries[$key]['cities'] = $cities->groupBy('cities.id')->get();
            }
        }

        foreach ($countries as $key => $country) {
            if($country['cities']->isEmpty()) {
                unset($countries[$key]);
            } 
        }

        return $countries;
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

    public function deleteAllByCompany($company_id) 
    {
        $packages = $this->model->where('company_id', $company_id)->get();
       
        foreach ($packages as $key => $package) {
            $transits = $this->transit_model->where('package_id', $package->id)->get();
            if($transits)
                $transits->each->delete();
    
            $files = $this->file_manager_model->where('model_type', 'package')->where('package_id', $package->id)->get();
            if($files)
                $files->each->delete();

            $package->delete($package->id);    
        }

        return true;
    }

    public function confirm($request) 
    {
        $user = auth('sanctum')->user();

        $package = $this->model->where('id', $request['package_id'])->first();
       
        if($package) {
            $confirmation = $this->package_confirm_model->create([
                'user_id'      => $user->id,
                'package_id'   => $package->id,
                'paid_status'  => 1,
                'due_date'     => $request['start_date'],
                'end_date'     => $request['end_date'],
                'no_of_guests' => $request['no_of_guests'],
            ]);

            return [
                'package_name'     => $package->name,
                'price_per_person' => $package->price_per_person,
                'start_date'       => $request['start_date'],
                'guests'           => $request['no_of_guests'],
                'total_amount'     => $request['no_of_guests'] * $package->price_per_person,
            ];
        }

        return false;
    }


    public function deals($user_id) 
    {
        $packages = $this->model->join('package_confirms', 'package_confirms.package_id', 'packages.id')
                                ->select('packages.*', 'package_confirms.due_date AS confirmed_start_date', 'package_confirms.end_date AS confirmed_end_date', 'package_confirms.no_of_guests AS confirmed_no_of_guests')
                                ->with(['Company', 'Transits', 'Transits.To', 'From', 'To', 'Files', 'Confirms.User.Files'])
                                ->where('package_confirms.user_id', $user_id)
                                ->get();
        
        $packages->each(function ($package) use ($user_id) {
            $package->confirms->each(function ($confirm) use ($package) {
                $filteredFiles = $confirm->user->files->filter(function ($file) use ($package) {
                    return $file->package_id === $package->id;
                })->values();
        
                // Overwrite the files relationship
                $confirm->user->setRelation('files', $filteredFiles);
            });

            $filteredConfirms = $package->confirms->filter(function ($confirm) use ($user_id) {
                return $confirm->user_id === $user_id;
            })->values();
    
            // Overwrite the confirms relationship
            $package->setRelation('confirms', $filteredConfirms);
        });

        return $packages->toArray();
    }

    public function all_user_packages($user_id) 
    {
        return $this->model->with(['Transits', 'Transits.To', 'From', 'To', 'Files'])
                           ->where('user_id', $user_id)
                           ->get()
                           ->toArray();    
    }
    
}
