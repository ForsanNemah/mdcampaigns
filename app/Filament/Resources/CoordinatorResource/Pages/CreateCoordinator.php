<?php

namespace App\Filament\Resources\CoordinatorResource\Pages;

use App\Filament\Resources\CoordinatorResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCoordinator extends CreateRecord
{
    protected static string $resource = CoordinatorResource::class;


    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
