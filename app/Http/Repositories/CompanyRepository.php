<?php

namespace App\Http\Repositories;

use App\Models\Company;

class CompanyRepository
{
    private $model;

    public function __construct(Company $company = null) 
    {
        $this->model = $company;
    }
    
    public function all() 
    {
        return $this->model->with(['Files'])->get();
    }

    public function update($id, $array) 
    {
        return $this->model->where('id', $id)->update($array);    
    }

    public function delete($id) 
    {
        return $this->model->where('id', $id)->delete();    
    }
}
