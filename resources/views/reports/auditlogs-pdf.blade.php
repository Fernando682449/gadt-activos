<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte Bitácora</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h2 { margin: 0 0 8px 0; }
        .muted { color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; vertical-align: top; }
        th { background: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
    <h2>Reporte de Bitácora</h2>
    <p class="muted">Generado: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Módulo</th>
            <th>Acción</th>
            <th>Usuario</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $l)
            <tr>
                <td>{{ $l->fecha ? \Carbon\Carbon::parse($l->fecha)->format('d/m/Y H:i') : '—' }}</td>
                <td>{{ $l->modulo ?? '—' }}</td>
                <td>{{ $l->accion ?? '—' }}</td>
                <td>{{ $l->user?->name ?? ($l->user_id ?? '—') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="muted">Total: {{ $logs->count() }} registros</p>
</body>
</html>