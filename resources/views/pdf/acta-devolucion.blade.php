<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acta de Devolución</title>
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

    <div class="title">Acta de Devolución de Bien</div>
    <div class="sub">Gobierno Autónomo Departamental de Tarija</div>

    <table class="no-border">
        <tr>
            <td><b>Fecha:</b> {{ $a->fecha_asignacion ?? '—' }}</td>
            <td class="text-right"><b>N° de acta:</b> {{ $a->id ?? '—' }}</td>
        </tr>
    </table>

    <p>
        Mediante la presente, se deja constancia de la <b>devolución</b> del activo institucional descrito a continuación,
        mismo que fue entregado por el funcionario responsable y recibido por el encargado o administrador del sistema,
        para su correspondiente registro, control y resguardo.
    </p>

    <div class="section-title">Datos del activo</div>

    <table>
        <thead>
            <tr>
                <th>Código patrimonial</th>
                <th>Tipo de activo</th>
                <th>Marca</th>
                <th>Estado</th>
                <th>Ubicación de recepción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $a->asset->codigo_patrimonial ?? '—' }}</td>
                <td>{{ $a->asset->type?->name ?? '—' }}</td>
                <td>{{ $a->asset->brand?->name ?? '—' }}</td>
                <td>{{ $a->asset->status?->name ?? '—' }}</td>
                <td>{{ $a->location?->name ?? '—' }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <tr>
            <th style="width: 30%;">Descripción del equipo</th>
            <td>
                {{ $a->observaciones ?? $a->asset->observaciones ?? 'Sin observaciones registradas.' }}
            </td>
        </tr>
    </table>

    <div class="section-title">Responsables</div>

    <table>
        <tr>
            <th style="width: 30%;">Funcionario que devuelve</th>
            <td>
                {{ $a->custodian?->nombre_completo ?? trim(($a->custodian->nombres ?? '') . ' ' . ($a->custodian->apellidos ?? '')) ?: '—' }}
            </td>
        </tr>
        <tr>
            <th>Usuario que recibe</th>
            <td>{{ $usuario->name ?? '—' }}</td>
        </tr>
    </table>

    <p class="small">
        Se firma la presente acta como constancia de la devolución del bien descrito, para fines de control administrativo,
        seguimiento institucional y respaldo documental.
    </p>

    <table class="firma">
        <tr>
            <td>
                <div class="linea"></div>
                <div>Firma del funcionario</div>
                <div class="small">(Devuelve)</div>
            </td>
            <td>
                <div class="linea"></div>
                <div>Firma del encargado / administrador</div>
                <div class="small">(Recibe)</div>
            </td>
        </tr>
    </table>

</body>
</html>