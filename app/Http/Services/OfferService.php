<?php

namespace App\Http\Services;

use App\Domains\Offers\Repositories\OfferRepository AS DomainOfferRepository;
use App\Http\Repositories\OfferRepository;

class OfferService
{
    private $domain_offer_repository;
    private $offer_repository;

    public function __construct(OfferRepository $offer_repository = null, DomainOfferRepository $domain_offer_repository) 
    {
        $this->domain_offer_repository = $domain_offer_repository;
        $this->offer_repository        = $offer_repository;
    }

    public function get_all() 
    {
        return $this->offer_repository->all();    
    }

    public function delete($request) 
    {
        return $this->offer_repository->delete($request['offer_id']);
    }

}
