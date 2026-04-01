<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceRequest;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\Maintenance;
use App\Models\Status;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $assets = Asset::orderBy('codigo_patrimonial')->get();
        return view('maintenances.create', compact('assets'));
    }

    public function store(StoreMaintenanceRequest $request)
    {
        $data = $request->validated();
        $maintenance = null;
        $asset = null;
        $statusName = null;

        DB::transaction(function () use ($data, &$maintenance, &$asset, &$statusName) {

            $maintenance = Maintenance::create([
                'asset_id' => $data['asset_id'],
                'tipo' => $data['tipo'],
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_fin' => $data['fecha_fin'] ?? null,
                'proveedor_tecnico' => $data['proveedor_tecnico'] ?? null,
                'costo' => $data['costo'] ?? null,
                'descripcion_falla' => $data['descripcion_falla'] ?? null,
                'trabajo_realizado' => $data['trabajo_realizado'] ?? null,
                'estado' => $data['estado'],
                'user_id' => Auth::id(),
            ]);

            $asset = Asset::with(['type', 'brand', 'status', 'custodian'])->findOrFail($data['asset_id']);

            $statusName = in_array($data['estado'], ['ABIERTO', 'EN_PROCESO'])
                ? 'En reparación'
                : 'Activo';

            $status = Status::where('name', $statusName)->first();
            if ($status) {
                $asset->update(['status_id' => $status->id]);
                $asset->refresh();
                $asset->load(['type', 'brand', 'status', 'custodian']);
            }

            $nombreCustodio = $asset->custodian?->nombre_completo
                ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? ''));

            $codigoActivo = $asset->codigo_patrimonial ?? 'Sin código';
            $tipoActivo   = $asset->type?->name ?? 'Sin tipo';
            $marcaActivo  = $asset->brand?->name ?? 'Sin marca';
            $estadoActivo = $asset->status?->name ?? 'Sin estado';
            $usuario      = auth()->user()->name ?? 'Usuario del sistema';
            $proveedor    = $data['proveedor_tecnico'] ?? 'No especificado';
            $fechaInicio  = $data['fecha_inicio'] ?? '—';
            $fechaFin     = $data['fecha_fin'] ?? '—';
            $costo        = $data['costo'] ?? '—';
            $falla        = $data['descripcion_falla'] ?? 'No especificada';
            $trabajo      = $data['trabajo_realizado'] ?? 'No especificado';

            AssetHistory::create([
                'asset_id' => $asset->id,
                'evento' => 'MANTENIMIENTO ' . $data['tipo'],
                'detalle' => "Se registró mantenimiento {$data['tipo']} para el activo {$codigoActivo} ({$tipoActivo} - {$marcaActivo}). Estado del mantenimiento: {$data['estado']}. Estado actual del activo: {$estadoActivo}. Fecha de inicio: {$fechaInicio}. Fecha de finalización: {$fechaFin}. Proveedor o técnico: {$proveedor}. Costo: {$costo}. Falla reportada: {$falla}. Trabajo realizado: {$trabajo}. Responsable actual: " . ($nombreCustodio ?: 'Sin custodio asignado') . ". Registro realizado por {$usuario}.",
                'fecha_evento' => now(),
                'user_id' => Auth::id(),
            ]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'accion'  => "Se registró mantenimiento {$data['tipo']} del activo {$codigoActivo} ({$tipoActivo} - {$marcaActivo}). Estado del mantenimiento: {$data['estado']}. Estado actual del activo: {$estadoActivo}. Inicio: {$fechaInicio}. Fin: {$fechaFin}. Proveedor/técnico: {$proveedor}. Costo: {$costo}. Responsable actual: " . ($nombreCustodio ?: 'Sin custodio asignado') . ". Operación realizada por {$usuario}.",
                'modulo'  => 'Mantenimientos',
                'fecha'   => now(),
            ]);
        });

        return redirect()
            ->route('assets.index')
            ->with('success', 'Mantenimiento registrado y trazabilidad actualizada.');
    }
}