<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCampaign extends ViewRecord
{
    protected static string $resource = CampaignResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label(__('labels.drop_ToRecycleBin')),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\EditAction::make()
        ];
    }
}
