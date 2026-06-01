<?php

namespace App\Filament\Resources\Insumos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class InsumoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->label('Nome do Insumo'),
                Select::make('unidade_medida')
                    ->options([
                        'unidade' => 'Unidade',
                        'metro' => 'Metro',
                        'kg' => 'Quilograma',
                        'litro' => 'Litro',
                        'dúzia' => 'Dúzia',
                    ])
                    ->required()
                    ->default('unidade')
                    ->label('Unidade de Medida'),
                TextInput::make('preco_custo')
                    ->numeric()
                    ->prefix('R$')
                    ->label('Preço de Custo'),
                TextInput::make('estoque')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->label('Quantidade em Estoque'),
            ]);
    }
}

