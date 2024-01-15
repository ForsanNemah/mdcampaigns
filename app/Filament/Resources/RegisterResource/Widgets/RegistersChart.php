<?php

namespace App\Filament\Resources\RegisterResource\Widgets;

use Filament\Widgets\ChartWidget;

class RegistersChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
