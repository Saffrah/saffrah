<?php

namespace App\Domains\FileManager\Services;

use App\Domains\Company\Services\CompanyService;
use App\Domains\FileManager\Repositories\FileManagerRepository;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;


class FileManagerService 
{
    private $file_manager_repository;
    private $company_service;
    private $package_service;

    public function __construct(
        CompanyService $company_service,
        FileManagerRepository $file_manager_repository
    ) 
    {
        $this->company_service         = $company_service;
        $this->file_manager_repository = $file_manager_repository;
    }

    public function storeFile($request)
    {
        $company  = auth('sanctum')->user();
        $uploaded = false;
        foreach ($request['files'] as $key => $file) {
            $file_name = $company->id.'_'.str_replace(' ', '_', $company->name).'_'.$request['model_type'].'.'.$file->getClientOriginalExtension();
            $uploaded  = $file->move(public_path('uploads'), $file_name);
            
            $array     = [
                'company_id'    => $company->id,
                'model_type'    => $request['model_type'],
                'package_id'    => isset($request['package_id']) ? $request['package_id'] : NULL,
                'file_name'     => $file_name,
                'download_link' => public_path('uploads').'/'.$file_name
            ];

            $created = $this->file_manager_repository->create($array);

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
     * @param $reportId
     */
    public function getFile($reportId = null)
    {
        $company = Company::getAuthCompany();
        if ($company) {
            return $this->file_manager_repository->getAll($company->id, $reportId);
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

    /**
     * @param $id
     */
    public function changeStatus($id)
    {
        $file = $this->file_manager_repository->getOne($id);
        $file->file_status = '反映完了';
        $file->save();
    }


}