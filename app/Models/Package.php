<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\FileManager\Models\FileManager;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'name_ar',
        'from_city',
        'to_city',
        'no_of_nights',
        'price_per_person',
        'hotel_name',
        'hotel_name_ar',
        'reservation_type',
        'is_cruise',
        'end_date',
        'description',
        'description_ar'
    ];

    public function Company() 
    {
        return $this->belongsTo(Company::class);    
    }

    public function Confirms()
    {
        return $this->hasMany(PackageConfirm::class);
    }

    public function User() 
    {
        return $this->belongsTo(User::class);    
    }

    public function Transits() 
    {
        return $this->hasMany(Transit::class);    
    }

    public function From() 
    {
        return $this->belongsTo(City::class, 'from_city');    
    }

    public function To() 
    {
        return $this->belongsTo(City::class, 'to_city');    
    }

    public function Files() 
    {
        return $this->hasMany(FileManager::class)->where('model_type', 'package');    
    }

    public function Offers() 
    {
        return $this->belongsToMany(Offer::class, 'offer_packages');
    }
}
