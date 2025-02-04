<?php

namespace App\Domains\FileManager\Services;

use App\Domains\FileManager\Repositories\FileManagerRepository;
use App\Domains\Company\Services\CompanyService;
use App\Models\Company;
use App\Models\Package;
use App\Models\User;

class FileManagerService 
{
    private $file_manager_repository;
    private $company_service;
    private $package_service;

    public function __construct(
        FileManagerRepository $file_manager_repository,
        CompanyService        $company_service
    ) 
    {
        $this->file_manager_repository = $file_manager_repository;
        $this->company_service         = $company_service;
    }

    public function storeFile($request)
    {
        $auth     = auth('sanctum')->user();
        $uploaded = false;

        foreach ($request['files'] as $key => $file) {
            $file_name = $auth->id.'_'.str_replace(' ', '_', $auth->name).'_'.($key+1).'_'.$request['model_type'].date('Ymd_His').'.'.$file->getClientOriginalExtension();
            $uploaded  = $file->move(public_path('uploads'), $file_name);
            
            if($request['model_type'] == 'company') {
                $entity = Company::find($request['model_id']);
                $model_type = Company::class;
            } elseif($request['model_type'] == 'package') {
                $entity = Package::find($request['model_id']);
                $model_type = Package::class;
            } elseif ($request['model_type'] == 'user') {
                $entity = User::find($request['model_id']);
                $model_type = User::class;
            }

            if($entity) { 
                $array     = [
                    'model_id'      => $entity->id,
                    'model_type'    => $model_type,
                    'package_id'    => isset($request['package_id']) ? $request['package_id'] : NULL,
                    'file_name'     => $file_name,
                    'download_link' => '/uploads/'.$file_name
                ];
    
                $uploaded  = $this->file_manager_repository->create($array);
            } 
            else {
                return [
                    'response_code'    => 400,
                    'response_message' => $request['model_type'].' was not found !',
                    'response_data'    => NULL
                ];
            }
        }
  
        if($uploaded) {
            return [
                'response_code'    => 200,
                'response_message' => 'Uploaded Successfully !',
                'response_data'    => $uploaded
            ];
        }

        return [
            'response_code'    => 500,
            'response_message' => 'Uploaded Failed !',
            'response_data'    => NULL
        ];
    }

    /**
     * @param $package_id
     */
    public function getPackageFiles($package_id)
    {
        $company = auth('sanctum')->user();

        if ($company) {
            return $this->file_manager_repository->getAllPackageFiles($company->id, $package_id);
        }

        return null;
    }

    public function deleteFile($id)
    {
        $file = $this->file_manager_repository->getOne($id);
    
        try {
            $deletedFile = $file->delete();
            return true;
        } catch (\Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }


}