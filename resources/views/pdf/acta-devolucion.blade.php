<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acta de Devolución</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { text-align:center; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .sub { text-align:center; margin-bottom: 18px; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border:1px solid #333; padding:6px; }
        .no-border td { border:none; }
        .firma { margin-top: 50px; width:100%; }
        .firma td { border:none; text-align:center; padding-top:40px; }
        .linea { border-top:1px solid #333; width:80%; margin:0 auto; }
    </style>
</head>
<body>

    <div class="title">ACTA DE DEVOLUCIÓN DE BIEN</div>
    <div class="sub">Gobierno Autónomo Departamental de Tarija</div>

    <table class="no-border">
        <tr>
            <td><b>Fecha:</b> {{ $a->fecha_asignacion }}</td>
            <td style="text-align:right;"><b>N°:</b> {{ $a->id }}</td>
        </tr>
    </table>

    <p>
        Por medio de la presente, se deja constancia de la <b>DEVOLUCIÓN</b> del bien descrito,
        entregado por el funcionario responsable y recibido por el encargado/administrador de activos,
        conforme a normativa interna de control y custodia de bienes.
    </p>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Ubicación (recepción)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $a->asset->codigo_patrimonial }}</td>
                <td>{{ $a->asset->type?->name ?? '—' }}</td>
                <td>{{ $a->asset->brand?->name ?? '—' }}</td>
                <td>{{ $a->location?->name ?? '—' }}</td>
            </tr>
        </tbody>
    </table>

    <p><b>Devuelve:</b> {{ $a->custodian?->nombre_completo ?? '—' }}</p>
    <p><b>Recibe (usuario del sistema):</b> {{ $usuario->name ?? '—' }}</p>

    <table class="firma">
        <tr>
            <td>
                <div class="linea"></div>
                <div>Firma del funcionario (Devuelve)</div>
            </td>
            <td>
                <div class="linea"></div>
                <div>Firma del encargado (Recibe)</div>
            </td>
        </tr>
    </table>

</body>
</html>