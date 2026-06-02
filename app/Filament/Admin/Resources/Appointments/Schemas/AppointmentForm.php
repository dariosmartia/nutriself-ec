<?php

namespace App\Filament\Admin\Resources\Appointments\Schemas;

use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
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
                    ->label('Fecha y hora de cita')
                    ->native(false)
                    ->seconds(false)
                    ->required()
                    ->rule(function (Get $get, ?Appointment $record) {
                        return function (string $attribute, $value, Closure $fail) use ($get, $record) {
                            $appointmentStart = Carbon::parse($value);

                            // Solo bloquea días anteriores
                            if ($appointmentStart->toDateString() < now()->toDateString()) {
                                $fail('No se pueden agendar citas en fechas anteriores.');
                                return;
                            }

                            if ($appointmentStart->isSunday()) {
                                $fail('No se pueden agendar citas los domingos.');
                                return;
                            }

                            $serviceId = $get('service_id');

                            if (! $serviceId) {
                                $fail('Debe seleccionar un servicio antes de elegir la fecha y hora.');
                                return;
                            }

                            $service = Service::find($serviceId);

                            if (! $service) {
                                $fail('El servicio seleccionado no existe.');
                                return;
                            }

                            $durationMinutes = (int) $service->duration_minutes;
                            $transitionMinutes = 30;

                            $appointmentEnd = $appointmentStart
                                ->copy()
                                ->addMinutes($durationMinutes + $transitionMinutes);

                            $workdayStart = $appointmentStart->copy()->setTime(8, 0);
                            $workdayEnd = $appointmentStart->copy()->setTime(18, 0);

                            if (
                                $appointmentStart->lt($workdayStart) ||
                                $appointmentStart->gte($workdayEnd)
                            ) {
                                $fail('El horario permitido para citas es de 08:00 a 18:00.');
                                return;
                            }

                            if ($appointmentEnd->gt($workdayEnd)) {
                                $fail('La cita y el bloque de transición deben finalizar máximo a las 18:00.');
                                return;
                            }

                            $existingAppointments = Appointment::query()
                                ->with('service')
                                ->whereDate(
                                    'appointment_date',
                                    $appointmentStart->toDateString()
                                )
                                ->where('status', '!=', 'cancelled')
                                ->when(
                                    $record,
                                    fn ($query) => $query->where('id', '!=', $record->id)
                                )
                                ->get();

                            foreach ($existingAppointments as $existingAppointment) {
                                $existingStart = Carbon::parse(
                                    $existingAppointment->appointment_date
                                );

                                $existingDuration = (int) (
                                    $existingAppointment->service?->duration_minutes ?? 0
                                );

                                $existingEnd = $existingStart
                                    ->copy()
                                    ->addMinutes(
                                        $existingDuration + $transitionMinutes
                                    );

                                $hasOverlap =
                                    $appointmentStart->lt($existingEnd) &&
                                    $appointmentEnd->gt($existingStart);

                                if ($hasOverlap) {
                                    $fail(
                                        'Ya existe una cita en ese bloque horario. Debe respetarse la duración del servicio y 30 minutos entre citas.'
                                    );
                                    return;
                                }
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
