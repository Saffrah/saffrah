<?php

namespace App\Domains\FileManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'package_id',
        'file_name',
        'download_link',
    ];

    // Define the inverse polymorphic relationship
    public function model()
    {
        return $this->morphTo();
    }

}
