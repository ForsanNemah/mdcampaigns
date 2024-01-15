<?php

namespace App\Filament\Widgets;

use App\Models\Clinic;
use App\Models\Register;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;

class RegistersChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort=4;
    protected static bool $isLazy = false;

    public function getHeading(): string|Htmlable|null
    {
        return __('labels.registration_activities');
    }
    protected function getData(): array
    {
        $data = Trend::model(Register::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets'=>[
                [
                    'label'=>'registers statics',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ]
            ],
            'labels'=> $data->map(function(TrendValue $value) {
             $date=Carbon::createFromFormat('Y-m',$value->date);
             $formatDate=$date->format('M');
             return $formatDate;
            }),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

 }
