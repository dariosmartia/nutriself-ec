<?php

namespace App\Filament\Admin\Resources\Prospects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProspectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->searchable(),

                TextColumn::make('source')
                    ->label('Origen')
                    ->searchable(),

                TextColumn::make('campaign.name')
                    ->label('Campaña')
                    ->searchable()
                    ->placeholder('Sin campaña'),

                TextColumn::make('main_goal')
                    ->label('Objetivo principal')
                    ->searchable(),

                TextColumn::make('preferred_modality')
                    ->label('Modalidad preferida')
                    ->searchable(),

                TextColumn::make('interest_level')
                    ->label('Nivel de interés')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'low' => 'Bajo',
                        'medium' => 'Medio',
                        'high' => 'Alto',
                        default => '-',
                    })
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'new' => 'Nuevo',
                        'contacted' => 'Contactado',
                        'interested' => 'Interesado',
                        'converted' => 'Convertido',
                        'inactive' => 'Inactivo',
                        'discarded' => 'Descartado',
                        default => '-',
                    })
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
