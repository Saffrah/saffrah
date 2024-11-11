<?php

namespace App\Domains\Offers\Services;

// Repositories
use App\Domains\Offers\Repositories\OfferRepository;

class OfferService
{
    private $offer_repository;

    public function __construct(OfferRepository $offer_repository) 
    {
        $this->offer_repository = $offer_repository;
    }

    public function store($request) 
    {
        $user = auth('sanctum')->user();
        
        if($user) {
            $request['user_id'] = $user->id;
            $offer = $this->offer_repository->store($request);
            
            if($offer && isset($request['transits'])) { 
                $transits = $this->offer_repository->add_transit($offer->id, $request['transits']);
            }
    
            if($offer) {
                return [
                    'response_code'    => 200,
                    'response_message' => 'registered successfully !', 
                    'response_data'    => $this->offer_repository->by_id($offer->id)
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
            'response_message' => 'Client not found !', 
            'response_data'    => []
        ];
    }

    public function get_by_id($id) 
    {
        $results = $this->offer_repository->by_id($id);
        
        if($results) {
            return [
                'response_code'    => 200,
                'response_message' => 'Offer fitched successfully !', 
                'response_data'    => $results
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'fitching failed !', 
            'response_data'    => []
        ];
    }

    public function get_user_offer() 
    {
        $user = auth('sanctum')->user();
        
        if($user) {
            $results = $this->offer_repository->by_user_id($user->id);

            if($results) {
                return [
                    'response_code'    => 200,
                    'response_message' => 'Offers fitched successfully !', 
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
            'response_message' => 'User not found !', 
            'response_data'    => []
        ];
    }

    public function get_all_offers() 
    {
        $results = $this->offer_repository->all();
        
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
