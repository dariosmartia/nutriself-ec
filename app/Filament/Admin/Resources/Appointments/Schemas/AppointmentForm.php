<?php

namespace App\Filament\Admin\Resources\Appointments\Schemas;

use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->label('Paciente')
                    ->relationship('patient', 'first_name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('service_id')
                    ->label('Servicio')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DateTimePicker::make('appointment_date')
                    ->label('Fecha y hora')
                    ->native(false)
                    ->seconds(false)
                    ->required()
                    ->rule(function () {
                        return function (string $attribute, $value, Closure $fail) {
                            $date = Carbon::parse($value);

                            if ($date->lt(now())) {
                                $fail('No se pueden agendar citas en fechas anteriores.');
                            }

                            if ($date->isSunday()) {
                                $fail('No se pueden agendar citas los domingos.');
                            }

                            $hour = (int) $date->format('H');

                            if ($hour < 8 || $hour >= 18) {
                                $fail('El horario permitido para citas es de 08:00 a 18:00.');
                            }
                        };
                    }),

                Select::make('modality')
                    ->label('Modalidad')
                    ->options([
                        'presential' => 'Presencial',
                        'virtual' => 'Virtual',
                    ])
                    ->required(),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'attended' => 'Atendida',
                        'cancelled' => 'Cancelada',
                    ])
                    ->default('pending')
                    ->required(),

                Textarea::make('notes')
                    ->label('Observaciones')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
