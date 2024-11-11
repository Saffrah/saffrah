<?php

namespace App\Domains\Offers\Repositories;

use App\Models\Offer;
use App\Models\OfferTransit;

class OfferRepository
{
    private $model;
    private $offer_transit_model;
    
    public function __construct(Offer $model, OfferTransit $offer_transit_model) 
    {
        $this->model               = $model;
        $this->offer_transit_model = $offer_transit_model;
    }

    public function store($request) 
    {  
        return $this->model->create($request);
    }

    public function add_transit($offer_id, $request) 
    {
        $stored = true;

        foreach ($request as $key => $transit) {
            $transit['offer_id'] = $offer_id;
            $stored = $this->offer_transit_model->create($transit);

            if(!$stored)
                break;
        }

        return $stored;
    }

    public function by_id($id) 
    {
        return $this->model->where('id', $id)->with(['Transits', 'Transits.to_city', 'from_city', 'to_city'])->first();   
    }

    function by_user_id($id) 
    {
        return $this->model->where('user_id', $id)->with(['Transits', 'Transits.to_city', 'from_city', 'to_city'])->get();    
    }

    public function all() 
    {
        return $this->model->with(['User', 'Transits', 'Transits.to_city', 'from_city', 'to_city'])->get();
    }


}
