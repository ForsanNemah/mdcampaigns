<?php

namespace App\Livewire;

use App\Models\FollowUpStatus;
use App\Models\Platform;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ViewPlatform extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Platform::query())
            ->columns([
                TextColumn::make('platform_name'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->model(Platform::class)
                    ->form([
                        TextInput::make('platform_name')
                            ->required()
                            ->maxLength(255),
                    ])
            ])
            ->bulkActions([
             DeleteBulkAction::make()
            ])
            ->headerActions([
                \Filament\Tables\Actions\CreateAction::make()
                    ->model(Platform::class)
                    ->form([
                        TextInput::make('platform_name')
                            ->required()
                            ->maxLength(255),
                    ])
            ]);
    }

    public function render(): View
    {
        return view('livewire.view-platform');
    }
}
