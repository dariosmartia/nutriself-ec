<?php

namespace App\Filament\Admin\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.first_name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('patient.last_name')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('service.name')
                    ->label('Servicio')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('appointment_date')
                    ->label('Fecha y hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('modality')
                    ->label('Modalidad')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'presential' => 'Presencial',
                        'virtual' => 'Virtual',
                        default => $state,
                    })
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'attended' => 'Atendida',
                        'cancelled' => 'Cancelada',
                        default => $state,
                    })
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ]),
            ]);
    }
}
