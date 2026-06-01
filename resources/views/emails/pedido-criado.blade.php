<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Criado</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #4f46e5;
            color: white;
            padding: 24px 32px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 32px;
        }
        .content p {
            color: #374151;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        table th {
            background: #f3f4f6;
            padding: 10px 12px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            color: #6b7280;
        }
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #4f46e5;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #e5e7eb;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 32px;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pedido Criado com Sucesso!</h1>
        </div>

        <div class="content">
            <p>Olá <strong>{{ $pedido->cliente->nome }}</strong>,</p>
            <p>Seu pedido foi registrado com sucesso em nossa loja.</p>

            <h3>Detalhes do Pedido</h3>
            <p>
                <strong>Pedido #:</strong> {{ $pedido->id }}<br>
                <strong>Data:</strong> {{ \Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y H:i') }}<br>
                <strong>Status:</strong> {{ $pedido->status }}
            </p>

            <h3>Itens do Pedido</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Preço Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->itens as $item)
                    <tr>
                        <td>{{ $item->produto->nome ?? 'Produto' }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Valor Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
            </div>

            <p>Agradecemos pela preferência!</p>
        </div>

        <div class="footer">
            {{ config('app.name') }} &mdash; Todos os direitos reservados.
        </div>
    </div>
</body>
</html>