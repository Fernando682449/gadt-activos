<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acta de {{ $assignment->tipo_movimiento }}</title>
    <style>
        body{ font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title{ font-size: 18px; font-weight: 700; text-align:center; margin-bottom: 10px; }
        .sub{ text-align:center; color:#555; margin-bottom: 20px; }
        .box{ border:1px solid #ddd; padding:12px; border-radius:8px; margin-bottom:12px; }
        .row{ display:flex; gap:14px; }
        .col{ flex:1; }
        .label{ color:#666; font-size:10px; text-transform:uppercase; letter-spacing:.04em; }
        .value{ font-weight:700; margin-top:2px; }
        .firma{ margin-top:40px; display:flex; justify-content:space-between; }
        .line{ width:45%; border-top:1px solid #444; text-align:center; padding-top:6px; }
    </style>
</head>
<body>

<div class="title">ACTA DE {{ strtoupper($assignment->tipo_movimiento) }}</div>
<div class="sub">Gobierno Autónomo Departamental de Tarija — Sistema de Gestión de Activos</div>

<div class="box">
    <div class="row">
        <div class="col">
            <div class="label">Fecha</div>
            <div class="value">{{ \Carbon\Carbon::parse($assignment->fecha_asignacion)->format('d/m/Y') }}</div>
        </div>
        <div class="col">
            <div class="label">Código patrimonial</div>
            <div class="value">{{ $assignment->asset?->codigo_patrimonial ?? '—' }}</div>
        </div>
        <div class="col">
            <div class="label">Serie</div>
            <div class="value">{{ $assignment->asset?->numero_serie ?? '—' }}</div>
        </div>
    </div>
</div>

<div class="box">
    <div class="row">
        <div class="col">
            <div class="label">Custodio</div>
            <div class="value">{{ $assignment->custodian?->nombre_completo ?? ($assignment->custodian?->nombres.' '.$assignment->custodian?->apellidos) }}</div>
        </div>
        <div class="col">
            <div class="label">Ubicación</div>
            <div class="value">{{ $assignment->location?->name ?? '—' }}</div>
        </div>
    </div>
</div>

<div class="box">
    <div class="label">Observaciones</div>
    <div class="value" style="font-weight:400">{{ $assignment->observaciones ?? '—' }}</div>
</div>

<div class="firma">
    <div class="line">Firma Custodio</div>
    <div class="line">Firma Responsable / Encargado</div>
</div>

</body>
</html>