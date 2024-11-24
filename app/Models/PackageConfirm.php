<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageConfirm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'paid_status',
        'due_date',
        'end_date',
        'no_of_guests'
    ];

    public function User() 
    {
        return $this->belongsTo(User::class);    
    }

    
}
