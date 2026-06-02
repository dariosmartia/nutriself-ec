<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Campaign;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CampaignStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Campañas Activas', Campaign::where('status', 'active')->count()),

            Stat::make('Campañas Finalizadas', Campaign::where('status', 'finished')->count()),
        ];
    }
}
