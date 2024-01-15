<?php

namespace App\Filament\Resources;
use App\Enums\allStatus;
use App\Filament\Resources\ClinicResource\RelationManagers\CampaignsRelationManager;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CampaignResource\Pages;
use App\Filament\Resources\CampaignResource\RelationManagers;
use App\Models\Campaign;
use App\Models\Clinic;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $recordTitleAttribute='campaign_name';
    public static function getNavigationLabel(): string
    {
        return __('objects.campaigns');
    }
  public static function getGlobalSearchResultTitle(Model $record): string
  {
      return $record->campaign_name; // TODO: Change the autogenerated stub
  }

    public static function getGlobalSearchResultDetails(Model $record): array
    { // TODO: Change the autogenerated stub
        return [
            'clinic'=>$record->clinic->name
        ] ;
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();// TODO: Change the autogenerated stub
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() == 0 ? 'warning' : 'success';// TODO: Change the autogenerated stub
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('labels.campaign'))
                ->description(__('labels.campaign_data'))
                ->schema([
                Group::make()
                ->schema([
                 Section::make()
                     ->description(__('labels.basic_data'))
                     ->schema([
                    TextInput::make('campaign_name')
                    ->label(__('labels.name'))
                    ->required()
                    ->maxLength(255)
                    ->minLength(3),
                    TextInput::make('campaign_link')
                    ->label(__('labels.campaign_link'))
                    ->url()
                        ->required(),
                ]),
                Section::make(__('labels.campaign_data'))
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                    Select::make('customer')
                    ->label(__('labels.customer'))
                    ->options(Customer::query()->pluck('name', 'id'))
                    ->live()
                    ->required()
                    ->searchable()
                    ->preload()
                    ->default(function (Customer $customer){
                        return Customer::query()->first()?->id;
                    })
                    ->hidden(!isAdmin())
                    ->native(false)
                        ->columnSpanFull()
                        ->afterStateUpdated(fn (Forms\Set $set) => $set('clinic_id', null)),
                    Select::make('clinic_id')
                        ->label(__('labels.clinic'))
                        ->options(fn (Forms\Get $get): \Illuminate\Support\Collection =>
                        (isAdmin())?Clinic::query()->where('customer_id', $get('customer'))->pluck('name', 'id'):Clinic::query()->where('customer_id',auth()->user()->accountable_id)->pluck('name', 'id'))
                     ->preload()
                     ->required()
                     ->native(false)
                     ->default(function (Customer $customer){
                            return (isCustomer())?Clinic::where('customer_id',auth()->user()->accountable_id)->first()?->id:null;
                     })
                    ->hidden(isClinic())
                     ->columnSpanFull()
                     ])->hiddenOn(CampaignsRelationManager::class),
                    Select::make('platform_id')
                    ->label(__('labels.platform'))
                    ->relationship('platform','platform_name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                ]),
            ]),
            Group::make()
            ->schema([
             Section::make(__('labels.Date'))
            ->schema([
                DateTimePicker::make('start_date')
                ->label(__('labels.start_date'))
                ->before('expiry_date')
                ->native(false)
                ->minDate(now())
                    ->visibleOn('create')
                    ->prefix('Starts'),
                DateTimePicker::make('start_date')
                    ->label(__('labels.start_date'))
                    ->before('expiry_date')
                    ->native(false)
                    ->visibleOn('update')
                    ->prefix('Starts'),
                DateTimePicker::make('expiry_date')
                ->label(__('labels.expiry_date'))
                ->after('start_date')
                ->native(false)
                ->prefix('Expire'),
            ]),
            Section::make('Campaign')
            ->schema([
                TextInput::make('daily_exchange')
                ->label(__('labels.daily_exchange'))
                ->numeric(),
                Checkbox::make('Published')
            ]),
                Hidden::make('created_at')
                    ->hiddenOn('edit'),
                 Hidden::make('updated_at')
                 ->hiddenOn('create')
            ]),
        ])->columns(2),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('labels.id'))
                ->sortable(true)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('campaign_name')
                    ->label(__('labels.name'))
                    ->sortable(true)
                ->searchable()
                ->toggleable(),
                TextColumn::make('clinic.name')
                    ->label(__('labels.clinic'))
                    ->sortable(true)
                ->searchable()
                ->toggleable(),
                TextColumn::make('clinic.customer.name')
                    ->label(__('labels.customer'))
                    ->sortable(true)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('platform.platform_name')
                    ->label(__('labels.platform'))
                ->sortable(true)
                ->searchable()
                ->toggleable(),
                TextColumn::make('campaign_link')
                    ->label(__('labels.campaign_link'))
                ->copyable()
                ->copyMessage('Url Link copied')
                ->copyMessageDuration(1500)
                ->sortable(true)
                ->searchable()
                ->toggleable(),
                TextColumn::make('daily_exchange')
                  ->label(__('labels.daily_exchange'))
                ->sortable(true)
                ->searchable()
                ->toggleable(),
                TextColumn::make('registers_count')
                    ->counts('registers')
                    ->label(__('labels.registers_count'))
                    ->suffix('   '.__('objects.registers'))
                    ->color(function ($record)
                    {
                        if($record->registers_count==0){
                            return 'warning';
                        }
                        return ($record->registers_count>10)?'success':'info';
                    })
                    ->icon(function ($record)
                    {
                        return ($record->registers_count>5)?'heroicon-m-arrow-trending-up':'heroicon-m-arrow-trending-down';
                    })
                    ->sortable(true)
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label(__('labels.start_date'))
                    ->sortable(true)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('expiry_date')
                    ->label(__('labels.expiry_date'))
                    ->sortable(true)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('campaign_status')
                    ->label(__('labels.status'))
                    ->badge()
                ->sortable(true)
                ->searchable()
                ->toggleable(),
                TextColumn::make('Published')
                    ->label(__('labels.is_published'))
                    ->badge()
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

            ])
            ->filters([
            Filter::make('is_Published')
                ->label(__('labels.is_published'))
                ->query(
                function ($query){
                    return $query->where('Published',true);
                }
                ),
            Filter::make('is_blocked')
                ->label(__('actions.is_blocked'))
                ->query(
                function ($query){
                    return $query->where('campaign_status',false);
                }
                ),
                Filter::make('Customer')
                    ->label(__('labels.customer'))
                    ->form([
         Select::make('customer')
                            ->label(__('labels.customer'))
                            ->options(Customer::query()->pluck('name', 'id'))
                            ->live()
                            ->searchable()
                            ->preload()
                            ->hidden(!isAdmin())
                            ->native(false)
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('clinic', null)),
                        Select::make('clinic')
                            ->label(__('labels.clinic'))
                            ->options(fn (Forms\Get $get): \Illuminate\Support\Collection =>
                            (isAdmin())?Clinic::query()->where('customer_id', $get('customer'))->pluck('name', 'id'):Clinic::query()->where('customer_id',auth()->user()->accountable_id)->pluck('name', 'id')
                            )
                            ->preload()
                            ->native(false)
                            ->hidden(isClinic()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['customer'],
                                fn (Builder $query, $data): Builder => $query->whereRelation('clinic','customer_id','=',$data),
                            )
                            ->when(
                                $data['clinic'],
                                fn (Builder $query, $data): Builder => $query->where('clinic_id',$data),
                            );
                    })
                ->hiddenOn(CampaignsRelationManager::class),
            Filter::make('campaign period')
            ->form([
            DatePicker::make('start_Date')
                ->label(__('labels.start_date')),
            DatePicker::make('Expiry_Date')
                ->label(__('labels.expiry_date')),
            ])
            ->query(function (Builder $query, array $data): Builder {
            return $query
            ->when(
                $data['start_Date'],
                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
            )
            ->when(
                $data['Expiry_Date'],
                fn (Builder $query, $date): Builder => $query->whereDate('expiry_date', '<=', $date),
            );
        }),
            Filter::make('created_at')
            ->form([
            DatePicker::make('created_from')
                ->label(__('labels.created_from')),
            DatePicker::make('created_until')
                ->label(__('labels.created_until')),
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
            }),
                Tables\Filters\TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('labels.drop_ToRecycleBin')),
                    ExportBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\BulkAction::make('block')
                        ->label(__('labels.status_toggle'))
                        ->action(function (Collection $records){
                            $records->each(function ($record){
                                ($record->campaign_status==allStatus::Blocked)?$record->campaign_status=allStatus::Active:$record->campaign_status=allStatus::Blocked;
                                $record->save();
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->modalIcon('heroicon-o-x-circle'),
                    Tables\Actions\BulkAction::make('unPublish')
                        ->action(function (Collection $records){
                            $records->each(function ($record){
                                ($record->Published==allStatus::Active)?$record->Published=allStatus::Blocked:$record->Published=allStatus::Active;
                                 $record->save();
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->modalIcon('heroicon-o-x-circle'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
    ->schema([
        ComponentsSection::make('Campaigns')
        ->description(__('labels.campaign_data'))
        ->schema([
        ComponentsGroup::make()
        ->schema([
        ComponentsSection::make()
            ->description(__('labels.basic_data'))
        ->schema([
            TextEntry::make('campaign_name')
            ->label(__('labels.name')),
            TextEntry::make('id')
            ->label(__('labels.id')),
        ]),
        ComponentsSection::make('Campaign')
        ->schema([

            TextEntry::make('clinic.customer.name')
                ->label(__('labels.customer')),
            TextEntry::make('clinic.name')
                ->label(__('labels.clinic')),
            TextEntry::make('campaign_link')
                 ->label(__('labels.campaign_link'))
        ]),
        ComponentsSection::make('Campaign')
         ->schema([
            TextEntry::make('platform.platform_name')
                ->label(__('labels.platform')),
            TextEntry::make('daily_exchange')
                ->label(__('labels.daily_exchange'))
             ,
                ]),
    ]),
    ComponentsGroup::make()
    ->schema([
    ComponentsSection::make(__('labels.Date'))
         ->schema([
        TextEntry::make('start_date')
        ->label(__('start Date')),
        TextEntry::make('expiry_date')
        ->label(__('Expiry Date')),
    ]),
        ComponentsSection::make(__('labels.Date'))
            ->schema([
                TextEntry::make('created_at'),
                TextEntry::make('updated_at')
            ]),
    ComponentsSection::make('Campaign')
    ->schema([
        TextEntry::make('campaign_status')
        ->label(__('labels.status'))
            ->badge(),
        TextEntry::make('Published')
            ->label(__('labels.is_published'))
            ->badge(),
    ]),
    ]),
])->columns(2),
]);
}
    public static function getRelations(): array
    {
        return [
            RelationManagers\RegistersRelationManager::class
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('id','DESC')
        ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'view' => Pages\ViewCampaign::route('/{record}'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }

    /**
     * @param string|null $modelLabel
     */
    public static function getModelLabel(): string
    {
        return __('labels.campaign');
    }

    /**
     * @param string|null $pluralModelLabel
     */
    public static function getPluralModelLabel(): string
    {
        return __('objects.campaigns');
    }
}
