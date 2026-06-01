<?php

namespace App\Filament\Resources\Produtos\Pages;

use App\Filament\Resources\Produtos\ProdutosResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProdutos extends ListRecords
{
    protected static string $resource = ProdutosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->select('id', 'nome', 'referencia', 'preco_venda', 'created_at', 'updated_at');
    }
}
