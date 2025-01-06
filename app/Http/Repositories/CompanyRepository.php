<?php

namespace App\Http\Repositories;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepository
{
    private $model;

    public function __construct(Company $company = null) 
    {
        $this->model = $company;
    }

    public function find($id) 
    {
        return $this->model->with(['packages.confirms' => function ($query) {
            $query->select('package_id', DB::raw('SUM(no_of_guests) as total_guests'))->groupBy('package_id');
        }])->find($id);    
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
