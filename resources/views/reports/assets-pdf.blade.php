<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Activos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h2 { margin: 0 0 8px 0; }
        .muted { color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
    <h2>Reporte de Activos</h2>
    <p class="muted">
        Generado: {{ now()->format('d/m/Y H:i') }}
    </p>

    <table>
        <thead>
        <tr>
            <th>Código</th>
            <th>Serie</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Ubicación</th>
            <th>Marca</th>
            <th>Fecha compra</th>
            <th>Costo</th>
        </tr>
        </thead>
        <tbody>
        @foreach($assets as $a)
            <tr>
                <td>{{ $a->codigo_patrimonial }}</td>
                <td>{{ $a->numero_serie ?? '—' }}</td>
                <td>{{ $a->type?->name ?? '—' }}</td>
                <td>{{ $a->status?->name ?? '—' }}</td>
                <td>{{ $a->location?->name ?? '—' }}</td>
                <td>{{ $a->brand?->name ?? '—' }}</td>
                <td>{{ $a->fecha_compra ?? '—' }}</td>
                <td>{{ $a->costo ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="muted">Total: {{ $assets->count() }} activos</p>
</body>
</html>