<?php

namespace App\Filament\Admin\Resources\Prospects\Schemas;

use App\Models\Campaign;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;


class ProspectForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema
    ->components([
        TextInput::make('name')
            ->label('Nombre')
            ->required(),

        TextInput::make('phone')
            ->label('Teléfono')
            ->tel()
            ->required(),

        TextInput::make('email')
            ->label('Correo electrónico')
            ->email(),

        TextInput::make('source')
            ->label('Origen')
            ->required(),

        Select::make('campaign_id')
            ->label('Campaña')
            ->relationship('campaign', 'name')
            ->searchable()
            ->preload(),

        TextInput::make('main_goal')
            ->label('Objetivo principal'),

        TextInput::make('preferred_modality')
            ->label('Modalidad preferida'),

        Select::make('interest_level')
            ->label('Nivel de interés')
            ->options([
                'low' => 'Bajo',
                'medium' => 'Medio',
                'high' => 'Alto',
            ])
            ->default('medium')
            ->required(),

        Select::make('status')
            ->label('Estado')
            ->options([
                'new' => 'Nuevo',
                'contacted' => 'Contactado',
                'interested' => 'Interesado',
                'converted' => 'Convertido',
                'inactive' => 'Inactivo',
                'discarded' => 'Descartado',
            ])
            ->default('new')
            ->required(),

        Textarea::make('ai_summary')
            ->label('Resumen IA')
            ->columnSpanFull(),

        Textarea::make('notes')
            ->label('Observaciones')
            ->columnSpanFull(),
    ]);
    }
}
