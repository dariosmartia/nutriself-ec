<?php

namespace App\Filament\Admin\Resources\Campaigns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),

                Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'initial_assessment' => 'Valoración inicial',
                        'launch_promotion' => 'Promoción de lanzamiento',
                        'free_guide' => 'Guía gratuita',
                        'special_program' => 'Programa especial',
                    ])
                    ->required(),

                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),

                DatePicker::make('start_date')
                    ->label('Fecha de inicio'),

                DatePicker::make('end_date')
                    ->label('Fecha de fin'),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'active' => 'Activa',
                        'paused' => 'Pausada',
                        'finished' => 'Finalizada',
                    ])
                    ->default('draft')
                    ->required(),

                Textarea::make('main_message')
                    ->label('Mensaje principal')
                    ->columnSpanFull(),

                TextInput::make('objective')
                    ->label('Objetivo'),
            ]);
    }
}
