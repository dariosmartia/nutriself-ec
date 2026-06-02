<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Prospect;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommercialStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Prospectos Totales',
                Prospect::count()
            ),

            Stat::make(
                'Prospectos Nuevos',
                Prospect::where('status', 'new')->count()
            ),

            Stat::make(
                'Prospectos Interesados',
                Prospect::where('status', 'interested')->count()
            ),

            Stat::make(
                'Prospectos Convertidos',
                Prospect::where('status', 'converted')->count()
            ),
        ];
    }
}
