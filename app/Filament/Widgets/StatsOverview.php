<?php

namespace App\Filament\Widgets;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Currency', Currency::where('is_active', 1)->count())
            ->description('Active Currencies')               
            ->icon('heroicon-o-currency-dollar'),

            Stat::make('Rates', ExchangeRate::count())
            ->description('rates count')               
            ->icon('heroicon-o-chart-bar'),

            Stat::make('Date ', ExchangeRate::max('date') ?? 'none')
            ->description('Last Date Update')               
            ->icon('heroicon-o-calendar'),

            ];

    }
}
