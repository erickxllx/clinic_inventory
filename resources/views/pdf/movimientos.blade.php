<h2>Últimos Movimientos</h2>

<table width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border-bottom:1px solid #ccc; padding:6px;">Tipo</th>
            <th style="border-bottom:1px solid #ccc; padding:6px;">Producto</th>
            <th style="border-bottom:1px solid #ccc; padding:6px;">Cantidad</th>
            <th style="border-bottom:1px solid #ccc; padding:6px;">Fecha</th>
        </tr>
    </thead>

    <tbody>
        @foreach($moves as $m)
        <tr>
            <td style="padding:6px;">{{ $m->type }}</td>
            <td style="padding:6px;">{{ $m->product->name }}</td>
            <td style="padding:6px;">{{ $m->quantity }}</td>
            <td style="padding:6px;">{{ $m->date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
