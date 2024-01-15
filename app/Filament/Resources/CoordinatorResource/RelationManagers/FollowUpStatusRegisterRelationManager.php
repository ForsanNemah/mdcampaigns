<?php

namespace App\Filament\Resources\CoordinatorResource\RelationManagers;

use App\Filament\Resources\MarketerResource\RelationManagers\RegistersRelationManager;
use App\Models\Campaign;
use App\Models\FollowUpStatus;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FollowUpStatusRegisterRelationManager extends RelationManager
{
    protected static string $relationship = 'checked_statuses';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('id','DESC');
    }
    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at','desc'))
            ->columns([
                TextColumn::make('follow_up_status_id.current_status')
                    ->label(__('labels.status'))
                    ->badge()
                    ->color(function ($record){
                        return Color::hex($record->follow_up_status_id['status_theme']);
                    }),
                TextColumn::make('register.register_name')
                    ->label(__('labels.register')),
                TextColumn::make('register.campaign.campaign_name')
                    ->label(__('labels.campaign')),
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
                    }),
        TextColumn::make('created_at')
            ->label(__('checked_at')),
    ])
            ->filters([
                SelectFilter::make('follow_up_status_id')
                    ->label(__('labels.status'))
                    ->options(FollowUpStatus::all()->pluck('follow_up_status','id'))
                    ->searchable()
                    ->preload(),
                Filter::make('campaign')
               ->form([
                   Select::make('campaign_name')
                       ->label(__('labels.campaign'))
                       ->options(
                           Campaign::where('clinic_id',$this->ownerRecord->clinic_id)->pluck('campaign_name', 'id'))
                       ->native(false)
                       ->preload(),
               ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['campaign_name'],
                                fn (Builder $query) => $query->whereRelation('register','campaign_id','=',$data['campaign_name']),
                            );
                    }),

                Filter::make('created_at')
                    ->label(__('labels.created_at'))
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ]);
    }
}
