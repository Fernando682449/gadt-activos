<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Custodios</title>
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
    <h2>Reporte de Custodios</h2>
    <p class="muted">Generado: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>CI</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($custodians as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->name ?? '—' }}</td>
                <td>{{ $c->ci ?? '—' }}</td>
                <td>{{ $c->email ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="muted">Total: {{ $custodians->count() }} custodios</p>
</body>
</html>