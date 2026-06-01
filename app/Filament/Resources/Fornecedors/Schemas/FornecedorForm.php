<?php

namespace App\Filament\Resources\Fornecedors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FornecedorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nome')
                    ->required()
                    ->label('Nome')
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->label('E-mail')
                    ->maxLength(255),
                TextInput::make('endereco')
                    ->label('Endereço')
                    ->maxLength(255),
            ]);
    }
}
