<?php

namespace App\Filament\Resources\Pedidos\Pages;

use App\Filament\Resources\Pedidos\PedidoResource;
use App\Mail\PedidoCriado;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Mail;

class CreatePedido extends CreateRecord
{
    protected static string $resource = PedidoResource::class;

    protected function afterCreate(): void
    {
        $pedido = $this->record;

        $total = $pedido->itens()
            ->selectRaw('SUM(quantidade * preco_unitario) as total')
            ->value('total') ?? 0;

        $pedido->update(['valor_total' => $total]);

        // Envia e-mail de notificação para o cliente
        $pedido->load('cliente', 'itens');
        if ($pedido->cliente && $pedido->cliente->email) {
            Mail::to($pedido->cliente->email)
                ->send(new PedidoCriado($pedido));
        }
    }
}
