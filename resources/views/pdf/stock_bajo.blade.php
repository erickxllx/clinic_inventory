<h2>Medicamentos con Stock Bajo</h2>

<table width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border-bottom:1px solid #ccc; padding:6px;">Nombre</th>
            <th style="border-bottom:1px solid #ccc; padding:6px;">Actual</th>
            <th style="border-bottom:1px solid #ccc; padding:6px;">Mínimo</th>
        </tr>
    </thead>

    <tbody>
        @foreach($items as $i)
        <tr>
            <td style="padding:6px;">{{ $i->name }}</td>
            <td style="padding:6px;">{{ $i->current_qty }}</td>
            <td style="padding:6px;">{{ $i->min_stock }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
