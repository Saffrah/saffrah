<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\MonthlyIncome as ModelsMonthlyIncome;
use App\Models\Package;
use App\Models\PackageConfirm;
use Illuminate\Console\Command;

class MonthlyIncome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'income:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the monthly income monthly in MonthlyIncome Table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the previous month's income
        $lastMonth = now()->subMonth();
        $startDate = $lastMonth->copy()->startOfMonth();
        $endDate   = $lastMonth->copy()->endOfMonth();

        $confirmed_packages_sum = PackageConfirm::join('packages', 'package_confirms.package_id', '=', 'packages.id') // Assuming `package_id` links the tables
                                            ->whereBetween('package_confirms.created_at', [$startDate, $endDate])
                                            ->selectRaw('SUM(package_confirms.no_of_guests * packages.price_per_person) as total_income')
                                            ->value('total_income');

        $total_active_companies          = Company::whereBetween('created_at', [$startDate, $endDate])->whereNotNull('email_verified_at')->count();
        $total_active_packages           = Package::whereBetween('created_at', [$startDate, $endDate])->count();
        $total_active_confirmed_packages = PackageConfirm::whereBetween('created_at', [$startDate, $endDate])->count();

        $added = ModelsMonthlyIncome::create([
            'income'             => $confirmed_packages_sum ?? 0, // Default to 0 if no income
            'collect_date'       => $lastMonth->copy()->endOfMonth()->format('Y-m-d'),
            'active_companies'   => $total_active_companies,
            'active_packages'    => $total_active_packages,
            'confirmed_packages' => $total_active_confirmed_packages,
        ]);

        $this->info("Monthly income summarized successfully: $confirmed_packages_sum");
    }
}
