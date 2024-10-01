<?php

namespace App\Domains\FileManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'company_id',
        'model_type',
        'package_id',
        'file_name',
        'download_link',
    ];

}
