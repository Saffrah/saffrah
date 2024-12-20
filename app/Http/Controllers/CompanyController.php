<?php

namespace App\Http\Controllers;

use App\Http\Services\AdminService;
use App\Http\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $company_service;
    private $admin_service;

    public function __construct(CompanyService  $company_service = null, AdminService $admin_service = null)
    {
        $this->company_service = $company_service;
        $this->admin_service   = $admin_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = $this->company_service->get_all();
        
        return view('pages/companies', compact('companies'));
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
        if($this->company_service->updateStatus($request->input())) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
