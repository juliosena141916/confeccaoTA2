<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),

                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),

                DateTimePicker::make('email_verified_at')
                    ->label('Verificado em'),

                Select::make('roles')
                    ->label('Regras (Cargos)')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->columnSpanFull(),

                Select::make('permissions')
                    ->label('Permissões Diretas')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}