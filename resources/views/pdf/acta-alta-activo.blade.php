</html><!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acta de Alta de Activo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 28px;
            line-height: 1.45;
        }

        .header-table,
        .info-table,
        .data-table,
        .firma-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo-box {
            width: 90px;
        }

        .logo {
            width: 78px;
            height: auto;
        }

        .title-box {
            text-align: center;
        }

        .title {
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .meta {
            margin-top: 6px;
            font-size: 11px;
        }

        .intro {
            margin-top: 18px;
            margin-bottom: 14px;
            text-align: justify;
        }

        .section-title {
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 8px;
            text-transform: uppercase;
            background: #f2f2f2;
            border: 1px solid #999;
            padding: 6px 8px;
        }

        .data-table th,
        .data-table td,
        .info-table th,
        .info-table td {
            border: 1px solid #333;
            padding: 7px 8px;
            vertical-align: top;
        }

        .data-table th,
        .info-table th {
            background: #efefef;
            text-align: left;
        }

        .small {
            font-size: 11px;
        }

        .firma-table {
            margin-top: 55px;
        }

        .firma-table td {
            border: none;
            text-align: center;
            width: 50%;
            padding-top: 28px;
        }

        .linea {
            border-top: 1px solid #333;
            width: 80%;
            margin: 0 auto 6px auto;
        }

        .text-right {
            text-align: right;
        }

        .muted {
            color: #444;
        }
    </style>
</head>
<body>

    @php
        $logoPath = public_path('img/2.jpg');
        $logoBase64 = '';

        if (file_exists($logoPath)) {
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }
    @endphp

    <table class="header-table">
        <tr>
            <td class="logo-box">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" class="logo" alt="Logo Gobernación">
                @endif
            </td>

            <td class="title-box">
                <div class="title">Acta de Alta de Activo</div>
                <div class="subtitle">Gobierno Autónomo Departamental de Tarija</div>
                <div class="subtitle">Dirección de Tecnologías de la Información</div>
                <div class="meta">
                    <b>Fecha de emisión:</b> {{ now()->format('Y-m-d') }}
                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <b>Código patrimonial:</b> {{ $asset->codigo_patrimonial ?? '—' }}
                </div>
            </td>
        </tr>
    </table>

    <p class="intro">
        Mediante la presente, se deja constancia del <b>registro de alta</b> del activo institucional detallado a continuación,
        para fines de control, inventario, trazabilidad, respaldo documental y asignación de responsabilidad dentro del sistema
        de gestión de activos tecnológicos.
    </p>

    <div class="section-title">1. Datos generales del activo</div>

    <table class="data-table">
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

    <div class="section-title">2. Información complementaria</div>

    <table class="info-table">
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
            <th>N° de factura</th>
            <td>{{ $asset->nro_factura ?? '—' }}</td>
        </tr>
        <tr>
            <th>Descripción / Observaciones</th>
            <td>{{ $asset->observaciones ?? 'Sin observaciones registradas.' }}</td>
        </tr>
    </table>

    <div class="section-title">3. Responsables del registro</div>

    <table class="info-table">
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

    <p class="small muted" style="margin-top: 14px;">
        La presente acta se emite como respaldo documental del alta del activo dentro del sistema institucional de gestión de activos tecnológicos.
    </p>

    <table class="firma-table">
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