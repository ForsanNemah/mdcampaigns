<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\FollowUpStatus;
use App\Models\FollowUpStatus_Register;
use App\Models\Register;
use Blade;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
