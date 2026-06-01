<?php

namespace App\Filament\Resources\Estoques\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EstoqueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('produto.nome')
                    ->label('Produto'),
                TextEntry::make('quantidade')
                    ->label('Quantidade'),
                TextEntry::make('localizacao')
                    ->label('Localização'),
                TextEntry::make('quantidade_minima')
                    ->label('Quantidade Mínima'),
                TextEntry::make('valor')
                    ->money('BRL')
                    ->label('Valor'),
            ]);
    }
}
