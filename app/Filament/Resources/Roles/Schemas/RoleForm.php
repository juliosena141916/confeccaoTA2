<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome da Regra')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('guard_name')
                    ->label('Guard')
                    ->default('web')
                    ->required(),

                Select::make('permissions')
                    ->label('Permissões de Acesso')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}