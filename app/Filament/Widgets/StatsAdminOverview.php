<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use App\Models\Clinic;
use App\Models\Customer;
use App\Models\Marketer;
use App\Models\Register;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Static_;

class StatsAdminOverview extends BaseWidget
{
    protected static ?int $sort=3;
    protected static bool $isLazy = false;
    protected static ?string $pollingInterval = '60s';

    public function getvalue():int
    {
        $currentPeriodCounts=Register::whereDate('created_at','>=',Carbon::now()->subDays(30))->count();
        $previousPeriodCounts=Register::whereDate('created_at','<',Carbon::now()->subDays(30))->count();

        if ($previousPeriodCounts > 0) {
             // If it has decreased then it will give you a percentage with '-'
            $differenceInpercentage = ($currentPeriodCounts - $previousPeriodCounts)  / $previousPeriodCounts * 100;
        } else {
            $differenceInpercentage = $currentPeriodCounts > 0 ? 100 : 0;
        }
        return round($differenceInpercentage);
    }

    public function getCampaignvalue():int
    {
        $currentPeriodCounts=Campaign::whereDate('created_at','>=',Carbon::now()->subDays(30))->count();
        $previousPeriodCounts=Campaign::whereDate('created_at','<',Carbon::now()->subDays(30))->count();

        if ($previousPeriodCounts > 0) {
            // If it has decreased then it will give you a percentage with '-'
            $differenceInpercentage = ($currentPeriodCounts - $previousPeriodCounts)  / $previousPeriodCounts * 100;
        } else {
            $differenceInpercentage = $currentPeriodCounts > 0 ? 100 : 0;
        }
        return round($differenceInpercentage);
    }
    public function getLabel($value): string|null
    {
        return  ($value>0)?'%  increased this month ':'%  decreased this month ';
    }
    public function getIcon($value): string|null
    {
        return  ($value>0)?'heroicon-m-arrow-trending-up':'heroicon-m-arrow-trending-down';
    }
    public function getColor($value): string|null
    {
        return  ($value>0)?'success':'danger';
    }
    protected function getStats(): array
    {
        $registersValue=$this->getvalue();
        $campaignsValue=$this->getCampaignvalue();
        $registersCount= Register::count();
        $campaignsCount=Campaign::count();
     if (isAdmin()){
          $customers=Customer::count();
         return [
             Stat::make(__('objects.registers'), $registersCount)
                 ->description($registersValue.$this->getLabel($registersValue))
                 ->descriptionIcon($this->getIcon($registersValue))
                 ->color($this->getColor($registersValue)),
             Stat::make(__('objects.campaigns'),$campaignsCount)
                 ->description($campaignsValue.$this->getLabel($campaignsValue))
                 ->descriptionIcon($this->getIcon($campaignsValue))
                 ->color($this->getColor($campaignsValue)),
             Stat::make(__('objects.customers'),$customers)
                 ->description('customers using this Website')
                 ->descriptionIcon($this->getIcon($customers))
                 ->color($this->getColor($customers)),
         ];
     }
        if (isCustomer()){
            return [
                Stat::make(__('objects.registers'),$registersCount)
                    ->description($registersValue.$this->getLabel($registersValue))
                    ->descriptionIcon($this->getIcon($registersValue))
                    ->color($this->getColor($registersValue)),
                Stat::make(__('objects.campaigns'),$campaignsCount)
                    ->description($campaignsValue.$this->getLabel($campaignsValue))
                    ->descriptionIcon($this->getIcon($campaignsValue))
                    ->color($this->getColor($campaignsValue)),
                Stat::make(__('objects.clinics'), Clinic::count())
                    ->description('clinics using this Website')
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('success'),
            ];
        }
        if (isClinic() || isCoordinator()){

            return [
                Stat::make(__('objects.registers'),$registersCount)
                    ->description($registersValue.$this->getLabel($registersValue))
                    ->descriptionIcon($this->getIcon($registersValue))
                    ->color($this->getColor($registersValue)),
                Stat::make(__('objects.campaigns'),$campaignsCount)
                    ->description($campaignsValue.$this->getLabel($campaignsValue))
                    ->descriptionIcon($this->getIcon($campaignsValue))
                    ->color($this->getColor($campaignsValue)),
                Stat::make(__('objects.marketers'),Marketer::count())
                    ->description('marketers using this Website')
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->color('success'),
            ];
        }
        return [Stat::make(__('objects.registers'),$registersCount)
            ->description($registersValue.$this->getLabel($registersValue))
            ->descriptionIcon($this->getIcon($registersValue))
            ->color($this->getColor($registersValue)),
        ];
    }
}
