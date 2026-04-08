<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte General de Activos</title>
    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color:#111;
            margin:20px;
            line-height:1.35;
        }

        .header-table,
        .meta-table,
        .data-table{
            width:100%;
            border-collapse:collapse;
        }

        .header-table td{
            border:none;
            vertical-align:middle;
        }

        .logo-box{
            width:90px;
        }

        .logo{
            width:72px;
            height:auto;
        }

        .title-box{
            text-align:center;
        }

        .title{
            font-size:16px;
            font-weight:bold;
            text-transform:uppercase;
            margin-bottom:4px;
        }

        .subtitle{
            font-size:11px;
            margin-bottom:2px;
        }

        .meta-wrap{
            margin-top:10px;
            margin-bottom:12px;
        }

        .meta-table th,
        .meta-table td,
        .data-table th,
        .data-table td{
            border:1px solid #333;
            padding:5px 6px;
            vertical-align:top;
        }

        .meta-table th,
        .data-table th{
            background:#efefef;
            text-align:left;
        }

        .summary-box{
            margin-top:8px;
            margin-bottom:10px;
            font-size:10px;
        }

        .footer-note{
            margin-top:14px;
            font-size:9px;
            color:#444;
            text-align:right;
        }

        .text-center{
            text-align:center;
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
                <div class="title">Reporte General de Activos</div>
                <div class="subtitle">Gobierno Autónomo Departamental de Tarija</div>
                <div class="subtitle">Dirección de Tecnologías de la Información</div>
            </td>
        </tr>
    </table>

    <div class="meta-wrap">
        <table class="meta-table">
            <tr>
                <th style="width:20%;">Fecha de emisión</th>
                <td style="width:30%;">{{ now()->format('Y-m-d H:i') }}</td>
                <th style="width:20%;">Usuario</th>
                <td style="width:30%;">{{ $usuario->name ?? '—' }}</td>
            </tr>
        </table>
    </div>

    <div class="summary-box">
        <b>Total de activos:</b> {{ $assets->count() }}
    </div>

    <table class="data-table">
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
                <th>N° Factura</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $asset)
                <tr>
                    <td>{{ $asset->codigo_patrimonial ?? '—' }}</td>
                    <td>{{ $asset->numero_serie ?? '—' }}</td>
                    <td>{{ $asset->type?->name ?? '—' }}</td>
                    <td>{{ $asset->status?->name ?? '—' }}</td>
                    <td>{{ $asset->location?->name ?? '—' }}</td>
                    <td>{{ $asset->brand?->name ?? '—' }}</td>
                    <td>{{ $asset->fecha_compra ?? '—' }}</td>
                    <td>{{ $asset->costo ?? '—' }}</td>
                    <td>{{ $asset->nro_factura ?? '—' }}</td>
                    <td>
                        {{ $asset->custodian?->nombre_completo ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? '')) ?: '—' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No hay activos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        Sistema de Gestión de Activos Tecnológicos
    </div>

</body>
</html>