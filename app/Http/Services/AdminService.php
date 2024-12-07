<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminRepository;
use Illuminate\Support\Facades\Auth;

class AdminService
{
    private $admin_repository;

    public function __construct(AdminRepository $admin_repository = null) {
        $this->admin_repository = $admin_repository;
    }

    public function save($request) 
    {
        return $this->admin_repository->store($request);
    }

    public function loggedinAdmin() 
    {
        return Auth::guard('admin')->user();    
    }
}
