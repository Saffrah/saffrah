<?php

namespace App\Http\Controllers;

use App\Http\Services\AdminService;
use App\Http\Services\OfferService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    private $offer_service;
    private $admin_service;

    public function __construct(OfferService  $offer_service = null, AdminService $admin_service = null)
    {
        $this->offer_service = $offer_service;
        $this->admin_service = $admin_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = $this->offer_service->get_all();
        
        return view('pages/offers', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if($this->offer_service->delete($request->input())) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
}
