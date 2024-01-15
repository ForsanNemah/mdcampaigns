<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\RegisterResource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class lastRegisters extends BaseWidget
{
    protected static ?int $sort=5;
    protected static bool $isLazy = false;
    protected static ?string $pollingInterval = '60s';
    protected int | string |array $columnSpan='full';

    public static function getHeading(): ?string
    {
        return __('labels.last_registers');
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(RegisterResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at','desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('labels.id'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('register_name')
                    ->label(__('labels.name'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('doctor_name')
                    ->label(__('labels.doctor'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('register_phone')
                    ->label(__('labels.phone_number'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('register_service')
                    ->label(__('labels.service'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('registration_source')
                    ->label(__('labels.source'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('campaign.campaign_name')
                    ->label(__('labels.campaign'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('marketer.name')
                    ->label(__('labels.marketer'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('campaign.clinic.name')
                    ->label(__('labels.clinic'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('campaign.clinic.customer.name')
                    ->label(__('labels.customer'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('register_information')
                    ->label(__('labels.moore_information'))
                    ->limit(60)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('note')
                    ->label(__('labels.note'))
                    ->limit(60)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('latestStatus.follow_up_status_id.current_status')
                    ->label(__('labels.status'))
                    ->badge()
                    ->color(function ($record){
                        return Color::hex($record->latestStatus->follow_up_status_id['status_theme']);
                    })
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(__('labels.created_at'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('updated_at')
                    ->label(__('labels.updated_at'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
            ]);

    }
}
