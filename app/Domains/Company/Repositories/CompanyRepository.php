<?php

namespace App\Domains\Company\Repositories;

use App\Models\Company;

class CompanyRepository
{
    private $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    function register($request) 
    {
        return $this->model->create($request);
    }

    
}
