<?php

namespace App\Http\Controllers;

use App\Http\Services\AdminService;
use App\Http\Services\PackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    private $package_service;
    private $admin_service;

    public function __construct(PackageService  $package_service = null, AdminService $admin_service = null)
    {
        $this->package_service = $package_service;
        $this->admin_service   = $admin_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = $this->package_service->get_all();
        
        return view('pages/packages', compact('packages'));
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
    public function show()
    {
        $deals = $this->package_service->get_deals();

        return view('pages/deals', compact('deals'));
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
        if($this->package_service->updateStatus($request->input())) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if($this->package_service->delete($request->input())) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
}
