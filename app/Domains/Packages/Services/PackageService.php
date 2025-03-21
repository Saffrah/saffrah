<?php

namespace App\Domains\Packages\Services;

use App\Domains\Auth\Repositories\AuthRepository;
use App\Domains\FileManager\Repositories\FileManagerRepository;
use App\Domains\Packages\Repositories\PackageRepository;
use App\Mail\PackageConfirmation;
use App\Notifications\UserOfferAcceptedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class PackageService
{
    private $file_manager_repository;
    private $package_repository;
    private $auth_repository;

    public function __construct(PackageRepository $package_repository, AuthRepository $auth_repository, FileManagerRepository $file_manager_repository) 
    {
        $this->file_manager_repository = $file_manager_repository;
        $this->package_repository      = $package_repository;
        $this->auth_repository         = $auth_repository;
    }

    public function cities_list() 
    {
        $cities = $this->package_repository->get_cities();

        if($cities) {
            return [
                'response_code'    => 200,
                'response_message' => 'Cities Retrieved successfully !', 
                'response_data'    => $cities
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
        $company = auth('sanctum')->user();

        if($company) {
            $request['company_id'] = $company->id;
            $package = $this->package_repository->store($request);
            
            if($package && isset($request['transits'])) { 
                $transits = $this->package_repository->add_transit($package->id, $request['transits']);
            }

            if(isset($request['user_id'])) {
                $added = $this->package_repository->addToUserOffer([
                    'offer_id'   => $request['offer_id'],
                    'package_id' => $package->id
                ]);

                // Notify the user
                if($added) {
                    $user = $this->auth_repository->findOne($request['user_id']);
                    Notification::send($user, new UserOfferAcceptedNotification($user, $company));
                }
            }
    
            if($package) {
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

        return [
            'response_code'    => 400,
            'response_message' => 'Company not found !', 
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

    public function get_company_packages() 
    {
        $company = auth('sanctum')->user();
        
        if($company) {
            $results = $this->package_repository->by_company_id($company->id);

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

        return [
            'response_code'    => 400,
            'response_message' => 'Company not found !', 
            'response_data'    => []
        ];
    }

    public function get_all_packages($request) 
    {
        $results = $this->package_repository->get_by_country($request);
        
        if($results) {
            return [
                'response_code'    => 200,
                'response_message' => 'Packages fitched successfully !', 
                'response_data'    => array_values($results)
            ];
        }

        return [
            'response_code'    => 200,
            'response_message' => 'No Packages found !', 
            'response_data'    => []
        ];
    }

    public function edit($request) 
    {
        $company = auth('sanctum')->user();
        $package = $this->package_repository->get_one_by_company_id($company->id, $request['package_id']);
        
        if($company && $package) {
            $result  = $this->package_repository->update($request);
            
            if($result) {
                $this->package_repository->update_transits($request['package_id'], isset($request['transits']) ? $request['transits'] : null);
            }

            if($result) {
                return [
                    'response_code'    => 200,
                    'response_message' => 'registered successfully !', 
                    'response_data'    => $this->package_repository->by_id($request['package_id'])
                ];
            }

            return [
                'response_code'    => 400,
                'response_message' => 'registered failed !', 
                'response_data'    => []
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'This Package does not exist under your company !', 
            'response_data'    => []
        ];
    }

    public function delete($id) 
    {
        $results = $this->package_repository->delete($id);
        
        if($results) {
            return [
                'response_code'    => 200,
                'response_message' => 'Packages deleted successfully !', 
                'response_data'    => $results
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'the Package does not exist !', 
            'response_data'    => []
        ];
    }

    public function confirm($request) 
    {
        $user    = auth('sanctum')->user();
        $results = $this->package_repository->confirm($request);
        
        if($results) {
            try {
                Mail::to($user->email)->send(new PackageConfirmation($results));
            } catch (\Throwable $th) {
                //throw $th;
            }
            return [
                'response_code'    => 200,
                'response_message' => 'Packages Confirmed successfully !', 
                'response_data'    => $results
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'this Package does not exist !', 
            'response_data'    => []
        ];
    }

    public function getDeals() 
    {
        $user = auth('sanctum')->user();

        $results = $this->package_repository->deals($user->id);
        
        if($results) {

            foreach ($results as $key => $deal) {
                $results[$key]['user_docs'] = $this->file_manager_repository->getUserDocs($user->id, $deal['id'], $deal['confirmed_no_of_guests']); 
            }

            return [
                'response_code'    => 200,
                'response_message' => 'Deals retrieved successfully !', 
                'response_data'    => $results
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'No deals Yet !', 
            'response_data'    => []
        ];
    }


}
