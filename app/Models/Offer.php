<?php

namespace App\Models;

use App\Domains\FileManager\Models\FileManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_city',
        'to_city',
        'no_of_nights',
        'no_of_adults',
        'no_of_children',
        'start_date',
        'end_date',
        'max_price',
        'including_tickets',
        'including_hotels',
        'including_program',
        'note'
    ];

    public function User() 
    {
        return $this->belongsTo(User::class);    
    }

    public function Transits() 
    {
        return $this->hasMany(OfferTransit::class);    
    }

    public function From() 
    {
        return $this->belongsTo(City::class, 'from_city');    
    }

    public function To() 
    {
        return $this->belongsTo(City::class, 'to_city');  
    }

    public function Packages() 
    {
        return $this->belongsToMany(Package::class, 'offer_packages');
    }

}
