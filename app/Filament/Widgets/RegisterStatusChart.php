<?php

namespace App\Filament\Widgets;

use App\Enums\registerStatus;
use App\Models\FollowUpStatus;
use App\Models\Register;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class RegisterStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Registers Status';

    /**
     * @param string|null $heading
     */
    public function getHeading(): string|Htmlable|null
    {
        return __('labels.registers_status');
    }

    public static function setHeading(): string
    {
       return __('labels.registers_status');
    }
    protected static ?int $sort=4;
    protected static bool $isLazy = false;
    protected static ?string $pollingInterval = '60s';
    protected static string $color = 'info';
    protected function getData(): array
    {
        $registerStatus=Register::select([\DB::raw('followupstatus.follow_up_status,count(*) as count'),'followupstatus.status_theme'])
            ->groupBy('followupstatus.follow_up_status','followupstatus.status_theme')
            ->join('followupstatus','follow_up_status','=','current_status')
            ->orderBy('current_status','desc')
            ->get(['count','followupstatus.follow_up_status','followupstatus.status_theme'])
        ->toArray();
        $data=[];
        $color=[];
        $label=[];
        foreach ($registerStatus as $status ) {
           array_push($data,[$status['count']]);
            array_push($color,[$status['status_theme']]);
            array_push($label,[$status['follow_up_status']]);

        }

        return [
            'datasets'=>[
                [
                    'label'=>'registers Status',
                    'data' => array_values($data),
                    'backgroundColor' => array_values($color),
                    'borderColor' => array_values($color),


                ]
            ],
            'labels'=> array_values($label)
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
