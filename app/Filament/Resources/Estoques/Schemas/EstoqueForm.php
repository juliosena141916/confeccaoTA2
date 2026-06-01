<?php

namespace App\Filament\Resources\Estoques\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EstoqueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('produtos_Id')
                    ->relationship('produto', 'nome')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Selecione o Produto'),
                TextInput::make('quantidade')
                    ->numeric()
                    ->required()
                    ->label('Quantidade'),
                TextInput::make('localizacao')
                    ->label('Localização/Descrição')
                    ->nullable(),
                TextInput::make('quantidade_minima')
                    ->numeric()
                    ->default(0)
                    ->label('Quantidade Mínima'),
                TextInput::make('valor')
                    ->numeric()
                    ->prefix('R$')
                    ->label('Valor do Material')
                    ->nullable(),
            ]);
    }
}
