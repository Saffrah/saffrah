<?php

namespace App\Domains\FileManager\Services;

use App\Domains\FileManager\Repositories\FileManagerRepository;
use App\Domains\Company\Services\CompanyService;

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
        $company  = auth('sanctum')->user();
        $uploaded = false;
        foreach ($request['files'] as $key => $file) {
            $file_name = $company->id.'_'.str_replace(' ', '_', $company->name).'_'.$request['model_type'].now().'.'.$file->getClientOriginalExtension();
            $uploaded  = $file->move(public_path('uploads'), $file_name);
            
            $array     = [
                'company_id'    => $company->id,
                'model_type'    => $request['model_type'],
                'package_id'    => isset($request['model_id']) ? $request['model_id'] : NULL,
                'file_name'     => $file_name,
                'download_link' => '/public/uploads/'.$file_name
            ];

            $created  = $this->file_manager_repository->create($array);
            $uploaded = $created;
        }
  
        if($uploaded) {
            return [
                'response_code'    => 200,
                'response_message' => 'Uploaded Successfully !',
                'response_data'    => $uploaded
            ];
        }

        return [
            'response_code'    => 400,
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