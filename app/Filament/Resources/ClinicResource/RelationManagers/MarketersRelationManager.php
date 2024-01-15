<?php

namespace App\Filament\Resources\ClinicResource\RelationManagers;

use App\Filament\Resources\MarketerResource;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class MarketersRelationManager extends RelationManager
{
    protected static string $relationship = 'marketers';
    protected static bool $isLazy = false;
    public function form(Form $form): Form
    {
        return MarketerResource::form($form);
    }
    public function table(Table $table): Table
    {
        return MarketerResource::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at','desc'))
            ->headerActions([
                Tables\Actions\CreateAction::make('create_new_card')
                    ->authorize(true)
            ]);
    }
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make(__('labels.marketer_data'))
                    ->icon('heroicon-m-user')
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('labels.name'))
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('email')
                            ->label(__('labels.email'))
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('clinic.name')
                            ->label(__('labels.clinic'))
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('account.status')
                            ->label(__('labels.status'))
                            ->badge(),
                        TextEntry::make('created_at')
                            ->label(__('labels.created_at'))
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('updated_at')
                            ->label(__('labels.updated_at'))
                            ->weight(FontWeight::SemiBold),


                    ])->columns(2),
            ]);
    }


}
