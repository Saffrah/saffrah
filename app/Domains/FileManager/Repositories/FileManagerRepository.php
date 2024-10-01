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
     * すべて取得
     * @param $company_id
     * @param $reportId
     * 
     * @return Collection
     * */
    public function getAll($company_id, $reportId = null)
    {
        $query = $this->model->where('company_id', $company_id);
        if ($reportId) {
            $query->where('report_id', $reportId);
        }
        return $query->get();
    }

    public function getWithSpecs($company_id, $report_id, $referrer_id = null, $specs = [])
    {
        $query = $this->model->where('company_id', $company_id)
                             ->where('report_id', $report_id);

        if(isset($specs['service_name'])) {
            $query->where('service_name', $specs['service_name']);
        }
        if($referrer_id) {
            return $query->where('referrer_id', $referrer_id)->first();
        }
        
        return $query->get();
    }

    public function create($array = [])
    {
        return $this->model->create($array);
    }

}
    