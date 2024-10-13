<?php

namespace App\Domains\FileManager\Repositories;

use App\Domains\FileManager\Models\FileManager;

class FileManagerRepository
{
    private $model;

    public function __construct(FileManager $model) 
    {
        $this->model = $model;
    }

    public function getOne($id)
    {
        return $this->model->find($id);
    }

    /** 
     * All Registration Files
     * 
     * @return Collection
     * */
    public function getAllRegistrationFiles($company_id)
    {
        return $this->model->where('company_id', $company_id)->where('model_type', 'company')->whereNull('package_id')->get();
    }

    public function getAllPackageFiles($company_id, $package_id) 
    {
        return $this->model->where('company_id', $company_id)->where('model_type', 'package')->where('package_id', $package_id)->get();
    }

    public function create($array = [])
    {
        return $this->model->create($array);
    }

}
    