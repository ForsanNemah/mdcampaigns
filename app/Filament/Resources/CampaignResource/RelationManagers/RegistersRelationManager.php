<?php

namespace App\Filament\Resources\CampaignResource\RelationManagers;

use App\Filament\Resources\RegisterResource;
use App\Models\FollowUpStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistersRelationManager extends RelationManager
{

    protected static string $relationship = 'registers';

    protected static function getPluralRecordLabel(): ?string
    {
        return __('objects.registers');
    }

    /**
     * @return string|null
     */
    public static function getLabel(): ?string
    {
        return __('objects.registers');
    }
    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return RegisterResource::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScope(SoftDeletingScope::class)->orderBy('created_at','desc'))
            ->filters([
                SelectFilter::make('marketer')
                    ->label(__('labels.marketer'))
                    ->relationship('marketer', 'name',modifyQueryUsing: fn (Builder $query) => $query->where('clinic_id','=',$this->ownerRecord->clinic_id))
                    ->searchable()
                    ->preload()
                    ->hidden(isMarketer()),
                SelectFilter::make('current_status')
                    ->label(__('labels.status'))
                    ->options(FollowUpStatus::all()->pluck('follow_up_status','follow_up_status'))
                    ->searchable()
                    ->preload(),
            ]);

    }
}
