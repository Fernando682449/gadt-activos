<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .title { font-size: 16px; font-weight: bold; text-align:center; margin: 10px 0; }
    .muted { color:#666; font-size:11px; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    td, th { border:1px solid #ddd; padding:8px; }
    th { background:#f3f4f6; text-align:left; }
    .sig { margin-top:60px; width:100%; }
    .sig td { border:none; text-align:center; }
    .line { border-top:1px solid #111; width:80%; margin:0 auto; }
  </style>
</head>
<body>

  <table style="border:none;">
    <tr style="border:none;">
      <td style="border:none; width:70px;">
        <img src="{{ public_path('img/2.jpg') }}" style="width:60px; height:60px; object-fit:contain;">
      </td>
      <td style="border:none;">
        <div style="font-weight:bold;">Gobierno Autónomo Departamental de Tarija</div>
        <div class="muted">Sistema de Gestión de Activos</div>
      </td>
      <td style="border:none; text-align:right;" class="muted">
        Fecha: {{ \Carbon\Carbon::parse($a->fecha_asignacion)->format('d/m/Y') }}
      </td>
    </tr>
  </table>

  <div class="title">ACTA DE ASIGNACIÓN / ENTREGA DE ACTIVO</div>

  <table>
    <tr><th>Tipo de movimiento</th><td>{{ $a->tipo_movimiento }}</td></tr>
    <tr><th>Activo</th><td>{{ $a->asset?->codigo_patrimonial }} — {{ $a->asset?->numero_serie }}</td></tr>
    <tr><th>Marca</th><td>{{ $a->asset?->brand?->name ?? '—' }}</td></tr>
    <tr><th>Tipo</th><td>{{ $a->asset?->type?->name ?? '—' }}</td></tr>
    <tr><th>Ubicación</th><td>{{ $a->location?->name ?? '—' }}</td></tr>
    <tr><th>Custodio (recibe)</th><td>{{ $a->custodian?->nombre_completo ?? ($a->custodian?->nombres.' '.$a->custodian?->apellidos) }}</td></tr>
    <tr><th>Observaciones</th><td>{{ $a->observaciones ?? '—' }}</td></tr>
  </table>

  <table class="sig">
    <tr>
      <td>
        <div class="line"></div>
        <div><strong>Administrador / Entrega</strong></div>
        <div class="muted">{{ $usuario->name }}</div>
      </td>
      <td>
        <div class="line"></div>
        <div><strong>Custodio / Recibe</strong></div>
        <div class="muted">
          {{ $a->custodian?->nombre_completo ?? ($a->custodian?->nombres.' '.$a->custodian?->apellidos) }}
        </div>
      </td>
    </tr>
  </table>

</body>
</html>