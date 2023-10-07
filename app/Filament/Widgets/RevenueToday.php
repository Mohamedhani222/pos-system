<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueToday extends BaseWidget
{

    protected function getStats(): array
    {
        $total = Sale::whereDate('created_at', date('Y-m-d'))->sum('total_amount');
        return [
            Stat::make('اوردرات اليوم', $total),
            Stat::make('اوردرات اخر 7 ايام',
                number_format(Sale::where('created_at', '>=', now()->subDays(7)->startOfDay())->sum('total_amount'), 2)),
            Stat::make('اوردرات اخر 30 ايام',
                number_format(Sale::where('created_at', '>=', now()->subDays(30)->startOfDay())->sum('total_amount'), 2))

        ];
    }
}
