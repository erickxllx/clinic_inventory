<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Movimientos</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f3f4f6; border-bottom: 2px solid #ccc; padding: 8px; text-align: left; }
        td { border-bottom: 1px solid #eee; padding: 8px; }
        .entrada { color: green; font-weight: bold; }
        .salida { color: red; font-weight: bold; }
        .ajuste { color: orange; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Reporte de Movimientos de Inventario</h2>
        <p>Fecha de emisión: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Antes</th>
                <th>Después</th>
                <th>Registrado por</th>
            </tr>
        </thead>
        <tbody>
            {{-- AQUÍ ESTABA EL ERROR, AHORA USA $movements --}}
            @foreach($movements as $m)
                <tr>
                    <td>{{ $m->date }}</td>
                    <td>
                        @if(strtolower($m->type) == 'entrada')
                            <span class="entrada">Entrada</span>
                        @elseif(strtolower($m->type) == 'salida')
                            <span class="salida">Salida</span>
                        @else
                            <span class="ajuste">Ajuste</span>
                        @endif
                    </td>
                    <td>{{ $m->product->name ?? 'Producto Eliminado' }}</td>
                    <td>{{ $m->quantity }}</td>
                    <td>{{ $m->previous_qty }}</td>
                    <td>{{ $m->new_qty }}</td>
                    <td>{{ $m->user->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>