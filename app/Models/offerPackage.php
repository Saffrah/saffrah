<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offerPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'package_id'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public static function allPackagesExpired($offerId)
    {
        return self::where('offer_id', $offerId)
            ->whereHas('package', function ($query) {
                $query->where('end_date', '>=', Carbon::today());
            })
            ->doesntExist();
    }
}
