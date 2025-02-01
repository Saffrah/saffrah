<?php

namespace App\Console\Commands;

use App\Models\Offer;
use App\Models\offerPackage;
use App\Models\OfferTransit;
use App\Models\Package;
use Illuminate\Console\Command;

class DeletePackagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes old packages and requests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Package::where('end_date', '<', date('Y-m-d'))->delete();

        $offers = Offer::where('end_date', '<', date('Y-m-d'))->get();
        foreach ($offers as $key => $offer) 
        {
            if(offerPackage::allPackagesExpired($offer->id)) {
                offerPackage::where('offer_id', $offer->id)->delete();
                OfferTransit::where('offer_id', $offer->id)->delete();
                $offer->delete();
            }
        }
    }
}
