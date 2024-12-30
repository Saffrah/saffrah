<?php

namespace App\Http\Repositories;

use App\Domains\FileManager\Models\FileManager;
use App\Models\Package;
use App\Models\Transit;

class PackageRepository
{
    private $model;
    private $transit_model;
    private $file_manager_model;

    public function __construct(Package $package = null, Transit $transit, FileManager $file_manager) 
    {
        $this->model              = $package;
        $this->transit_model      = $transit;
        $this->file_manager_model = $file_manager;
    }
    
    public function all() 
    {
        return $this->model->with(['Transits', 'Transits.To', 'From', 'To', 'Files'])->get();
    }

    public function update($id, $array) 
    {
        return $this->model->where('id', $id)->update($array);    
    }

    public function delete($id) 
    {
        $package = $this->model->find($id);
       
        if($package) {
            $transits = $this->transit_model->where('package_id', $id)->get();
            if($transits)
                $transits->each->delete();
    
            $files = $this->file_manager_model->where('model_type', 'package')->where('package_id', $id)->get();
            if($files)
                $files->each->delete();

            return $package->delete();    
        }

        return false;    
    }
}
