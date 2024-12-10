<?php

namespace App\Domains\Auth\Repositories;

use App\Models\User;

class AuthRepository
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findOne($id)
    {
        return $this->model->find($id);    
    }

    function register($request) 
    {
        return $this->model->create($request);
    }

    
}
