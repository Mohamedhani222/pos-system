<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersPerDayChart extends ChartWidget
{
    protected static ?string $heading = 'Orders Per Day';
    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        $data = Trend::model(Sale::class)
            ->between(
                start: now()->subDays(60),
                end: now()
            )->perDay()
            ->count();


        return [
            'datasets' => [
                [
                    'label' => 'Orders per day',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
