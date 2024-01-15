<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Filament\Resources\ClinicResource;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClinicsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'clinics';
    protected static ?string $label = 'mm';

    public function form(Form $form): Form
    {
        return ClinicResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ClinicResource::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at','desc'))
            ->headerActions([
                Tables\Actions\CreateAction::make('create_new_card')
                    ->authorize(true)
            ]);
    }

    public  function infolist(Infolist $infolist): Infolist
    {
        return ClinicResource::infolist($infolist);
    }

}
