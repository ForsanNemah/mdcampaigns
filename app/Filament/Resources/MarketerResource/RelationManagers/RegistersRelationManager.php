<?php

namespace App\Filament\Resources\MarketerResource\RelationManagers;

use App\Filament\Resources\RegisterResource;
use App\Models\Campaign;
use App\Models\FollowUpStatus;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistersRelationManager extends RelationManager
{
    protected static bool $isLazy = false;

    protected static string $relationship = 'registers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return RegisterResource::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScope(SoftDeletingScope::class)->orderBy('created_at','desc'))
            ->filters([
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
                                fn (Builder $query) => $query->where('campaign_id','=',$data['campaign_name']),
                            );
                    }),
                SelectFilter::make('current_status')
                    ->label(__('labels.status'))
                    ->options(FollowUpStatus::all()->pluck('follow_up_status','follow_up_status'))
                    ->searchable()
                    ->preload(),
            ]);

    }
    public function infolist(Infolist $infolist): Infolist
    {
        return RegisterResource::infolist($infolist);
    }


}
