<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Altas y Bajas por Fecha</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111;
            margin: 24px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .sub {
            text-align: center;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .meta {
            margin-bottom: 16px;
            font-size: 11px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 8px;
            background: #f2f2f2;
            padding: 6px 8px;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th, td {
            border: 1px solid #333;
            padding: 5px 6px;
            vertical-align: top;
        }

        th {
            background: #efefef;
            text-align: left;
        }

        .empty {
            text-align: center;
            color: #555;
            padding: 12px;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
            color: #444;
        }
    </style>
</head>
<body>

    <div class="title">Reporte de Altas y Bajas por Fecha</div>
    <div class="sub">Gobierno Autónomo Departamental de Tarija</div>

    <div class="meta">
        <b>Rango consultado:</b>
        {{ $fechaInicio ?: 'Sin fecha inicial' }}
        al
        {{ $fechaFin ?: 'Sin fecha final' }}
        <br>
        <b>Búsqueda:</b> {{ $q ?: 'Sin texto de búsqueda' }}
        <b>Fecha de emisión:</b> {{ now()->format('Y-m-d H:i') }}
    </div>

    <div class="section-title">
        Activos dados de alta ({{ $altas->count() }})
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha alta</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Ubicación</th>
                <th>Responsable</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($altas as $asset)
                <tr>
                    <td>{{ optional($asset->created_at)->format('Y-m-d') }}</td>
                    <td>{{ $asset->codigo_patrimonial }}</td>
                    <td>{{ $asset->type?->name ?? '—' }}</td>
                    <td>{{ $asset->brand?->name ?? '—' }}</td>
                    <td>{{ $asset->location?->name ?? '—' }}</td>
                    <td>
                        {{ $asset->custodian?->nombre_completo ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? '')) ?: '—' }}
                    </td>
                    <td>{{ $asset->status?->name ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">No hay altas registradas en ese rango de fechas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">
        Activos dados de baja ({{ $bajas->count() }})
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha baja</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Ubicación</th>
                <th>Responsable</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bajas as $asset)
                <tr>
                    <td>{{ $asset->fecha_baja ?? '—' }}</td>
                    <td>{{ $asset->codigo_patrimonial }}</td>
                    <td>{{ $asset->type?->name ?? '—' }}</td>
                    <td>{{ $asset->brand?->name ?? '—' }}</td>
                    <td>{{ $asset->location?->name ?? '—' }}</td>
                    <td>
                        {{ $asset->custodian?->nombre_completo ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? '')) ?: '—' }}
                    </td>
                    <td>{{ $asset->status?->name ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">No hay bajas registradas en ese rango de fechas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Sistema de Gestión de Activos Tecnológicos
    </div>

</body>
</html>