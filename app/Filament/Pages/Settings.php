<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings';
    protected static bool $shouldRegisterNavigation = false;

    /**
     * @return string
     */
    public function mount(): void
    {
        abort_unless(isAdmin(), 403);
    }
}
