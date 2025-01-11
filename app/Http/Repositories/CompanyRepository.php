<?php

namespace App\Http\Repositories;

use App\Models\Company;
use App\Models\PackageConfirm;
use Illuminate\Support\Facades\DB;

class CompanyRepository
{
    private $model;
    private $package_confirm_model;

    public function __construct(Company $company = null, PackageConfirm $package_confirm = null) 
    {
        $this->model = $company;
        $this->package_confirm_model = $package_confirm;
    }

    public function find($id) 
    {
        return $this->model->with(['packages.confirms' => function ($query) {
            $query->select('package_id', DB::raw('SUM(no_of_guests) as total_guests'))->groupBy('package_id');
        }])->find($id);    
    }

    public function confirms($company_id) 
    {
        return $this->package_confirm_model->join('packages', 'packages.id', 'package_confirms.package_id')
                                           ->join('companies', 'companies.id', 'packages.company_id')
                                           ->select('package_confirms.*')
                                           ->where('companies.id', $company_id)
                                           ->get();
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
