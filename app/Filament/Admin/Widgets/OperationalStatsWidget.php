<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Appointment;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OperationalStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pacientes Totales', Patient::count()),

            Stat::make('Citas Pendientes', Appointment::where('status', 'pending')->count()),

            Stat::make('Citas Confirmadas', Appointment::where('status', 'confirmed')->count()),

            Stat::make('Citas Atendidas', Appointment::where('status', 'attended')->count()),
        ];
    }
}
