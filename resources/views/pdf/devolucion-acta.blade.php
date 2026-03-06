<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acta de Devolución</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { text-align:center; font-size: 16px; font-weight: bold; margin-bottom: 6px; }
        .sub { text-align:center; margin-bottom: 18px; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border:1px solid #333; padding: 6px; }
        th { background: #f2f2f2; }
        .sign { margin-top: 60px; width:100%; }
        .box { width:45%; display:inline-block; text-align:center; }
        .line { border-top:1px solid #333; margin-top: 40px; }
    </style>
</head>
<body>

<div class="title">ACTA DE DEVOLUCIÓN DE BIEN</div>
<div class="sub">
    Fecha: <b>{{ $a->fecha_asignacion }}</b>
</div>

<p>
    Por la presente se deja constancia de la <b>DEVOLUCIÓN</b> del bien asignado, en cumplimiento de normativa interna y control de bienes.
</p>

<p>
    <b>Funcionario (Custodio):</b> {{ $a->custodian->nombre_completo }} <br>
    <b>Cargo:</b> {{ $a->custodian->cargo ?? '—' }} <br>
    <b>Unidad:</b> {{ $a->custodian->unidad ?? '—' }} <br>
    <b>Ubicación de recepción:</b> {{ $a->location->name ?? '—' }}
</p>

<table>
    <thead>
        <tr>
            <th>Código patrimonial</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>N° Serie</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $a->asset->codigo_patrimonial }}</td>
            <td>{{ $a->asset->type->name ?? '—' }}</td>
            <td>{{ $a->asset->brand->name ?? '—' }}</td>
            <td>{{ $a->asset->numero_serie ?? '—' }}</td>
            <td>{{ $a->asset->status->name ?? '—' }}</td>
        </tr>
    </tbody>
</table>

@if($a->observaciones)
    <p><b>Observaciones:</b> {{ $a->observaciones }}</p>
@endif

<div class="sign">
    <div class="box">
        <div class="line"></div>
        <b>Entrega (Administrador)</b><br>
        {{ $usuario->name ?? '—' }}
    </div>

    <div style="width:8%; display:inline-block;"></div>

    <div class="box">
        <div class="line"></div>
        <b>Recibe / Devuelve (Custodio)</b><br>
        {{ $a->custodian->nombre_completo }}
    </div>
</div>

</body>
</html>