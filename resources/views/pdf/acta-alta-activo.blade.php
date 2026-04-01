<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acta de Alta de Activo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 35px;
            line-height: 1.45;
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
            margin-bottom: 18px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }

        .no-border td {
            border: none;
            padding: 2px 0;
        }

        .text-right {
            text-align: right;
        }

        .firma {
            margin-top: 55px;
            width: 100%;
        }

        .firma td {
            border: none;
            text-align: center;
            padding-top: 35px;
            width: 50%;
        }

        .linea {
            border-top: 1px solid #333;
            width: 80%;
            margin: 0 auto 6px auto;
        }

        .small {
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="title">Acta de Alta de Activo</div>
    <div class="sub">Gobierno Autónomo Departamental de Tarija</div>

    <table class="no-border">
        <tr>
            <td><b>Fecha:</b> {{ now()->format('Y-m-d') }}</td>
            <td class="text-right"><b>Código:</b> {{ $asset->codigo_patrimonial ?? '—' }}</td>
        </tr>
    </table>

    <p>
        Mediante la presente, se deja constancia del <b>registro de alta</b> del activo institucional detallado a continuación,
        para fines de control, inventario, trazabilidad y asignación de responsabilidad dentro del sistema de gestión de activos.
    </p>

    <div class="section-title">Datos del activo</div>

    <table>
        <thead>
            <tr>
                <th>Código patrimonial</th>
                <th>Tipo de activo</th>
                <th>Marca</th>
                <th>Estado</th>
                <th>Ubicación</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $asset->codigo_patrimonial ?? '—' }}</td>
                <td>{{ $asset->type?->name ?? '—' }}</td>
                <td>{{ $asset->brand?->name ?? '—' }}</td>
                <td>{{ $asset->status?->name ?? '—' }}</td>
                <td>{{ $asset->location?->name ?? '—' }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <tr>
            <th style="width: 30%;">Número de serie</th>
            <td>{{ $asset->numero_serie ?? '—' }}</td>
        </tr>
        <tr>
            <th>Responsable / Custodio</th>
            <td>
                {{ $asset->custodian?->nombre_completo ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? '')) ?: '—' }}
            </td>
        </tr>
        <tr>
            <th>Fecha de compra</th>
            <td>{{ $asset->fecha_compra ?? '—' }}</td>
        </tr>
        <tr>
            <th>Costo</th>
            <td>{{ $asset->costo ?? '—' }}</td>
        </tr>
        <tr>
            <th>Descripción / Observaciones</th>
            <td>{{ $asset->observaciones ?? 'Sin observaciones registradas.' }}</td>
        </tr>
    </table>

    <div class="section-title">Responsables del registro</div>

    <table>
        <tr>
            <th style="width: 30%;">Usuario que registra</th>
            <td>{{ $usuario->name ?? '—' }}</td>
        </tr>
        <tr>
            <th>Responsable asignado</th>
            <td>
                {{ $asset->custodian?->nombre_completo ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? '')) ?: '—' }}
            </td>
        </tr>
    </table>

    <p class="small">
        Se emite la presente acta como respaldo documental del alta del activo dentro del sistema institucional.
    </p>

    <table class="firma">
        <tr>
            <td>
                <div class="linea"></div>
                <div>Firma del responsable asignado</div>
            </td>
            <td>
                <div class="linea"></div>
                <div>Firma del administrador / usuario del sistema</div>
            </td>
        </tr>
    </table>

</body>
</html>