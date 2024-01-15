<?php

namespace App\Filament\Resources\MarketerResource\Pages;

use App\Filament\Resources\MarketerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketers extends ListRecords
{
    protected static string $resource = MarketerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
