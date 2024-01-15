<?php

namespace App\Filament\Resources\ClinicResource\RelationManagers;

use App\Filament\Resources\CampaignResource;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CampaignsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'campaigns';

    public function form(Form $form): Form
    {
        return CampaignResource::form($form);
    }


    public function table(Table $table): Table
    {
      return CampaignResource::table($table)
          ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScope(SoftDeletingScope::class)->orderBy('created_at','desc'))
          ->headerActions([
              Tables\Actions\CreateAction::make('create_new_card')
                  ->authorize(true)
          ]);
    }
}
