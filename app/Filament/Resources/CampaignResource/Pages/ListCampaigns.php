<?php

namespace App\Filament\Resources\CampaignResource\Pages;
use App\Filament\Resources\CampaignResource;
use App\Models\Campaign;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCampaigns extends ListRecords
{
    protected static string $resource = CampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
{
    return [
        __('labels.all_campaigns') => Tab::make()
        ->badge(Campaign::count()),
        __('labels.recent_campaigns') => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at','>=',now()->subDays(7)))
            ->badge(Campaign::query()->where('created_at','>=',now()->subDays(7))->count()),
        __('labels.this_month') => Tab::make()
        ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at','>=',now()->subDays(30)))
        ->badge(Campaign::query()->where('created_at','>=',now()->subDays())->count()),
    ];

}


}
