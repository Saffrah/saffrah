<?php

namespace App\Domains\Company\Repositories;

use App\Models\Company;
use App\Models\Package;

class CompanyRepository
{
    private $model;
    private $package_model;

    public function __construct(Company $model, Package $package)
    {
        $this->model         = $model;
        $this->package_model = $package;
    }

    function register($request) 
    {
        return $this->model->create($request);
    }

    public function deals($company_id) 
    {
        return $this->package_model->join('package_confirms', 'package_confirms.package_id', 'packages.id')
                                   ->select('packages.*', 'package_confirms.due_date AS confirmed_start_date', 'package_confirms.end_date AS confirmed_end_date', 'package_confirms.no_of_guests AS confirmed_no_of_guests')
                                   ->with(['Transits', 'Transits.To', 'From', 'To', 'Files'])
                                   ->where('packages.company_id', $company_id)
                                   ->get()
                                   ->toArray();    
    }
    
}
