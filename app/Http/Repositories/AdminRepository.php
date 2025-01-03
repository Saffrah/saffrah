<?php

namespace App\Http\Repositories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    private $model;

    public function __construct(Admin $admin = null) 
    {
        $this->model = $admin;
    }

    public function getAll() 
    {
        return $this->model->all();    
    }
    
    public function store($request) 
    {
        return $this->model->create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
            'role'     => isset($request['role']) ? $request['role'] : 'admin'
        ]);    
    }

    public function delete($id) 
    {
        return $this->model->where('id', $id)->delete();    
    }
}
