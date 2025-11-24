<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f1f5f9; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 10px; text-align: center; }
    </style>
</head>
<body>

<div class="header">
    <h1>Reporte de Medicamentos</h1>
    <p>Fecha generado: {{ $fecha }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Presentación</th>
            <th>Actual</th>
            <th>Mínimo</th>
        </tr>
    </thead>

    <tbody>
    @foreach($medicamentos as $m)
        <tr>
            <td>{{ $m->name }}</td>
            <td>{{ $m->presentation }}</td>
            <td>{{ $m->current_qty }}</td>
            <td>{{ $m->min_stock }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    Sistema de Inventario Clínico - {{ date('Y') }}
</div>

</body>
</html>
