<?php

namespace App\Domains\Company\Repositories;

use App\Models\Company;
use App\Models\Package;
use Illuminate\Support\Facades\Log;

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
        $packages = $this->package_model->with(['Transits', 'Transits.To', 'From', 'To', 'Files', 'Confirms.User.Files'])
                                        ->where('packages.company_id', $company_id)
                                        ->get();

        $packages->each(function ($package) {
            $package->confirms->each(function ($confirm) use ($package) {
                $filteredFiles = $confirm->user->files->filter(function ($file) use ($package) {
                    return $file->package_id === $package->id;
                })->values();
        
                // Overwrite the files relationship
                $confirm->user->setRelation('files', $filteredFiles);
            });
        });

        return $packages->toArray();
  
    }
    
}
