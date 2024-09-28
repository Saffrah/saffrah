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

    function register($request) 
    {
        return $this->model->create($request);
    }

    
}
