<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ServiceStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Servicios Activos',
                Service::where('is_active', true)->count()
            ),
        ];
    }
}
