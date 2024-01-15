<?php

namespace App\Filament\Resources\RegisterResource\Pages;

use App\Filament\Resources\RegisterResource;
use Filament\Actions;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\AttachAction;

class EditRegister extends EditRecord
{
    protected static string $resource = RegisterResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            // ...
        ];
    }
}
