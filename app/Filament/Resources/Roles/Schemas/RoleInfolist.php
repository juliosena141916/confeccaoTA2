<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nome da Regra'),

                TextEntry::make('guard_name')
                    ->label('Guard'),

                RepeatableEntry::make('permissions')
                    ->label('Permissões')
                    ->schema([
                        TextEntry::make('name'),
                    ])
                    ->columns(1),
            ]);
    }
}