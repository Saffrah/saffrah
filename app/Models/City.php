<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function Packages() 
    {
        return $this->hasMany(Package::class, 'to_city');    
    }
}
