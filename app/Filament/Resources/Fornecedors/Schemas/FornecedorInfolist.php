<?php

namespace App\Filament\Resources\Fornecedors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FornecedorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextEntry::make('nome')
                    ->label('Nome'),
                TextEntry::make('email')
                    ->label('E-mail'),
                TextEntry::make('endereco')
                    ->label('Endereço'),
            ]);
    }
}
