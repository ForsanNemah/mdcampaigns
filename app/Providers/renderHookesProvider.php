<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class renderHookesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::body.end',
            fn (): View => view('livewire.footer-component'),
        );
    }
}
