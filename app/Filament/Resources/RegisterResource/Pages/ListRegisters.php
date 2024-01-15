<?php

namespace App\Filament\Resources\RegisterResource\Pages;

use App\Enums\registerStatus;
use App\Filament\Resources\RegisterResource;
use App\Models\FollowUpStatus;
use App\Models\Register;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Builder;

class ListRegisters extends ListRecords
{
    protected static string $resource = RegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {

    $data=[];
        $data['all registers']=Tab::make()
        ->badge(Register::count());
        $status= FollowUpStatus::get();
        foreach ($status as $status ){
           $data[$status->follow_up_status]=Tab::make()
               ->modifyQueryUsing(fn(Builder $query) => $query->where('current_status', '=', $status->follow_up_status))
               ->badge(Register::query()->where('current_status', '=', $status->follow_up_status)->count());
        }
        return  $data;
    }

}
