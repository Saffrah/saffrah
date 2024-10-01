<?php

namespace App\Domains\FileManager\Controllers;

use App\Domains\FileManager\Requests\CSVFileSeederRequest;
use App\Domains\FileManager\Services\FileManagerService;
use App\Domains\FileManager\Requests\StoreFileRequest;
use App\Domains\FileManager\Mail\FileUploaded;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Imports\CSVFilesImporter;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Services\AuthService;
use App\Services\ReferrerEmailService;

class FileManagerController extends Controller
{
    private $file_manager_service;

    public function __construct(FileManagerService $file_manager_service)
    {
        $this->file_manager_service = $file_manager_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('file_upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        $response = $this->file_manager_service->storeFile($request->validated());

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $files = $this->file_manager_service->getFile($request->report_id);
        $user  = Auth::user();
        
        if($files) {
            return response()->json([
                'code'    => 200,
                'status'  => 'success',
                'message' => '',
                'body'    => $files,
            ]);
        }

        return response()->json([
            'code'    => 400,
            'status'  => 'failed',
            'message' => 'no such file',
            'body'    => ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id) {
            return response()->json([
                'code'    => 200,
                'status'  => 'success',
                'message' => '',
                'body'    => $this->file_manager_service->deleteFile($id)
            ]);
        }

        return response()->json([
            'code'    => 400,
            'status'  => 'failed',
            'message' => 'no such file',
            'body'    => ''
        ]);
    }

    /**
     * update file status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeFileStatus($id) 
    {
        if($id) {
            $this->file_manager_service->changeStatus($id);
            return response()->json([
                'code'    => 200,
                'status'  => 'success',
                'message' => '',
            ]);
        } else {
            return response()->json([
                'code'    => 400,
                'status'  => 'failed',
                'message' => 'no such file',
            ]);
        }
    }

}
