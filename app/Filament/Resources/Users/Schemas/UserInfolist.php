<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nome'),

                TextEntry::make('email')
                    ->label('E-mail'),

                TextEntry::make('email_verified_at')
                    ->label('Verificado em')
                    ->dateTime(),

                RepeatableEntry::make('roles')
                    ->label('Regras (Cargos)')
                    ->schema([
                        TextEntry::make('name'),
                    ])
                    ->columns(1),

                RepeatableEntry::make('permissions')
                    ->label('Permissões Diretas')
                    ->schema([
                        TextEntry::make('name'),
                    ])
                    ->columns(1),
            ]);
    }
}