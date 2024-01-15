<?php

namespace App\Filament\Resources\MarketerResource\Pages;

use App\Filament\Resources\MarketerResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMarketer extends CreateRecord
{
    protected static string $resource = MarketerResource::class;

    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
