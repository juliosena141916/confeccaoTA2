<?php

namespace App\Filament\Resources\Produtos;

use App\Filament\Resources\Produtos\Pages\CreateProdutos;
use App\Filament\Resources\Produtos\Pages\EditProdutos;
use App\Filament\Resources\Produtos\Pages\ListProdutos;
use App\Filament\Resources\Produtos\Pages\ViewProdutos;
use App\Filament\Resources\Produtos\Schemas\ProdutosForm;
use App\Filament\Resources\Produtos\Schemas\ProdutosInfolist;
use App\Filament\Resources\Produtos\Tables\ProdutosTable;
use App\Models\Produtos;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class ProdutosResource extends Resource
{
    protected static ?string $model = Produtos::class;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('access_produtos') ?? false;
    }

    protected static string|UnitEnum|null $navigationGroup = 'Estoque';
    //
    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Produto';

    protected static ?string $modelLabel = 'Produto';

    protected static ?string $pluralModelLabel = 'Produtos';


    protected static ?string $recordTitleAttribute = 'produtos';

    public static function form(Schema $schema): Schema
    {
        // return ProdutosForm::configure($schema);
        return $schema
            ->schema([
                TextInput::make('nome')->required()->label('Nome do Produto'),
                TextInput::make('referencia')->label('Código/Referência'),
                TextInput::make('preco_venda')->numeric()->prefix('R$')->label('Preço de Venda'),
                TextInput::make('estoque')->numeric()->default(0),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProdutosInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // return ProdutosTable::configure($table);
        return $table
            ->columns([
                TextColumn::make('referencia')->searchable(),
                TextColumn::make('nome')->searchable(),
                TextColumn::make('preco_venda')->money('BRL'),
                TextColumn::make('estoque'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProdutos::route('/'),
            'create' => CreateProdutos::route('/create'),
            'view' => ViewProdutos::route('/{record}'),
            'edit' => EditProdutos::route('/{record}/edit'),
        ];
    }
}
