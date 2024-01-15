<?php

namespace App\Filament\Resources\RegisterResource\RelationManagers;

use App\Models\FollowUpStatus_Register;
use App\Models\Register;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FollowUpStatusRelationManager extends RelationManager
{
    protected static string $relationship = 'FollowUpStatus';
    protected static ?string $model = FollowUpStatus_Register::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('follow_up_status')
                    ->required()
                    ->maxLength(255),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('follow_up_status_register.created_at','desc'))
            ->allowDuplicates()
            ->recordTitleAttribute('follow_up_status')
            ->columns([
                TextColumn::make('follow_up_status')
                    ->label(__('labels.status'))
                     ->badge()
                    ->color(function ($record){
                           return Color::hex($record->status_theme);
                          }
                    ),
                TextColumn::make('coordinator.name')
                    ->label(__('checked_By')),
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
            ->headerActions([

                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextArea ::make('note')
                            ->label(false)
                            ->placeholder(__('labels.note')),
                        Hidden::make('coordinator_id')->required()
                            ->default(auth()->user()->accountable_id),
                    ])
                    ->preloadRecordSelect()
                    ->after(function () {
                            $register=Register::find($this->ownerRecord->id);
                           $this->ownerRecord->update(['current_status'=>$register->latestStatus->follow_up_status_id['current_status'],
                                'updated_at'=>Carbon::now()]);
                    })
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Coordinator Data')
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
