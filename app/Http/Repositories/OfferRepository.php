<?php

namespace App\Http\Repositories;

use App\Domains\FileManager\Models\FileManager;
use App\Models\Offer;
use App\Models\OfferTransit;

class OfferRepository
{
    private $model;
    private $transit_model;

    public function __construct(Offer $offer = null, OfferTransit $transit) 
    {
        $this->model         = $offer;
        $this->transit_model = $transit;
    }
    
    public function all() 
    {
        return $this->model->with(['Transits', 'Transits.To', 'From', 'To'])->get();
    }

    public function update($id, $array) 
    {
        return $this->model->where('id', $id)->update($array);    
    }

    public function delete($id) 
    {
        $offer = $this->model->find($id);
       
        if($offer) {
            $transits = $this->transit_model->where('offer_id', $id)->get();
            if($transits)
                $transits->each->delete();

            return $offer->delete();    
        }

        return false;    
    }
}
