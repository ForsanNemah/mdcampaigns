<?php

namespace App\Filament\Resources\ClinicResource\RelationManagers;

use App\Filament\Resources\CoordinatorResource;
use App\Models\Coordinator;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoordinatorsRelationManager extends RelationManager
{
    protected static string $relationship = 'coordinators';
    protected static bool $isLazy = false;
    public function form(Form $form): Form
    {
        return CoordinatorResource::form($form);
    }


    public function table(Table $table): Table
    {
      return CoordinatorResource::table($table)
          ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at','desc'))
          ->headerActions([
              Tables\Actions\CreateAction::make('create_new_card')
                  ->authorize(true)
          ]);
    }
}
