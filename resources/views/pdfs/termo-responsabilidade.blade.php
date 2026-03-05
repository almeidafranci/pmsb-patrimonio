<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.5; }
        h1 { text-align: center; font-size: 16px; margin-bottom: 5px; }
        h2 { text-align: center; font-size: 13px; font-weight: normal; margin-top: 0; color: #555; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 3px 8px; }
        .info-table .label { font-weight: bold; width: 160px; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.items th, table.items td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        table.items th { background-color: #e5e5e5; font-size: 11px; }
        .signatures { margin-top: 60px; width: 100%; }
        .signatures td { width: 50%; text-align: center; padding-top: 50px; }
        .signatures .line { border-top: 1px solid #333; display: inline-block; width: 250px; padding-top: 5px; }
        .footer { margin-top: 30px; font-size: 10px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <h1>TERMO DE RESPONSABILIDADE</h1>
    <h2>Patrimônio Municipal</h2>

    <table class="info-table">
        <tr>
            <td class="label">Requisição Nº:</td>
            <td>{{ $requisicao->id }}</td>
            <td class="label">Data:</td>
            <td>{{ $requisicao->data_requisicao->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Secretaria:</td>
            <td>{{ $requisicao->secretaria->nome }}</td>
            <td class="label">Departamento:</td>
            <td>{{ $requisicao->departamento?->nome ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Responsável:</td>
            <td colspan="3">{{ $requisicao->responsavel }}</td>
        </tr>
    </table>

    @if($tombamentos->isNotEmpty())
    <h3>Bens Tombados</h3>
    <table class="items">
        <thead>
            <tr>
                <th>Nº Tombamento</th>
                <th>Item</th>
                <th>Valor (R$)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tombamentos as $rt)
            <tr>
                <td>{{ $rt->tombamento->numero_tombamento ?? 'Pendente' }}</td>
                <td>{{ $rt->tombamento->item->nome }}</td>
                <td>{{ number_format($rt->tombamento->valor ?? 0, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($itens->isNotEmpty())
    <h3>Itens de Consumo</h3>
    <table class="items">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qtd. Solicitada</th>
                <th>Qtd. Atendida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itens as $ri)
            <tr>
                <td>{{ $ri->item->nome }}</td>
                <td>{{ $ri->quantidade_solicitada }}</td>
                <td>{{ $ri->quantidade_atendida }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($requisicao->observacao)
    <p><strong>Observação:</strong> {{ $requisicao->observacao }}</p>
    @endif

    <table class="signatures">
        <tr>
            <td>
                <div class="line">Responsável pelo Almoxarifado</div>
            </td>
            <td>
                <div class="line">{{ $requisicao->responsavel }}<br>Recebedor</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Documento gerado em {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
