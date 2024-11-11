<?php

namespace App\Domains\Offers\Controllers;

// Services
use App\Domains\Offers\Services\OfferService;

//Requests
use App\Domains\Offers\Requests\StoreOfferRequest;

// Liberaries
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    private $offer_service;

    public function __construct(OfferService $offer_service) 
    {
        $this->offer_service = $offer_service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request)
    {
        $result = $this->offer_service->store($request->validated());
        
        return response()->json($result);
    }

    public function get_offer($id) 
    {
        $result = $this->offer_service->get_by_id($id);

        return response()->json($result);
    }

    public function get_user_offers()
    {
        $result = $this->offer_service->get_user_offer();

        return response()->json($result);
    }

    public function all_offers() 
    {
        $result = $this->offer_service->get_all_offers();

        return response()->json($result);
    }


}