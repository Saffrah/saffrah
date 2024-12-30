<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTransit extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'to_city',
        'no_of_nights',
        'note'
    ];

    public function Offer() 
    {
        return $this->belongsTo(Offer::class);    
    }

    public function To() 
    {
        return $this->belongsTo(City::class, 'to_city');    
    }


}
