<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transit extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'to_city',
        'no_of_nights',
        'hotel_name',
        'hotel_name_ar',
        'description',
        'description_ar'
    ];

    public function Package() 
    {
        return $this->belongsTo(Package::class);    
    }

    public function To() 
    {
        return $this->belongsTo(City::class, 'to_city');    
    }
}
