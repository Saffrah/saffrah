<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'name_ar',
        'from_city',
        'to_city',
        'no_of_nights',
        'price_per_person'
    ];
}
