<?php

namespace App\Livewire;

use App\Models\FollowUpStatus;
use App\Models\Shop\Product;
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

class ViewStatus extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(FollowUpStatus::query())
            ->columns([

                TextColumn::make('follow_up_status')
                    ->label(__('labels.status'))
                    ->badge()
                    ->color(function ($record){
                        return Color::hex($record->status_theme);
                    }),
                ColorColumn::make('status_theme'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->model(FollowUpStatus::class)
                    ->form([
                        TextInput::make('follow_up_status')
                            ->required()
                            ->maxLength(255),
                        ColorPicker::make('status_theme')
                            ->label('color')
                            ->translateLabel()
                            ->required()
                    ])
            ])
            ->bulkActions([
                DeleteBulkAction::make()
            ])
            ->headerActions([
                \Filament\Tables\Actions\CreateAction::make()
                    ->model(FollowUpStatus::class)
                    ->form([
                        TextInput::make('follow_up_status')
                            ->required()
                            ->maxLength(255),
                        ColorPicker::make('status_theme')
                            ->label('color')
                            ->translateLabel()
                        ->required()
                    ])
            ]);
    }

    public function render(): View
    {
        return view('livewire.view-status');
    }
}
