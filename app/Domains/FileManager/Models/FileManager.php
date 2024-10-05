<?php

namespace App\Domains\FileManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'model_type',
        'package_id',
        'file_name',
        'download_link',
    ];

}
