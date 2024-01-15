<?php

namespace App\Filament\Resources\MarketerResource\Pages;

use App\Filament\Resources\MarketerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMarketer extends ViewRecord
{
    protected static string $resource = MarketerResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\EditAction::make()
        ];
    }
}
