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

        DB::transaction(function () use ($data) {

            Maintenance::create([
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

            $asset = Asset::findOrFail($data['asset_id']);

            $statusName = in_array($data['estado'], ['ABIERTO', 'EN_PROCESO'])
                ? 'En reparación'
                : 'Activo';

            $status = Status::where('name', $statusName)->first();
            if ($status) {
                $asset->update(['status_id' => $status->id]);
            }

            AssetHistory::create([
                'asset_id' => $asset->id,
                'evento' => 'MANTENIMIENTO ' . $data['tipo'],
                'detalle' => "Estado: {$data['estado']} | Inicio: {$data['fecha_inicio']} | Fin: " .
                            ($data['fecha_fin'] ?? '—') . " | Costo: " . ($data['costo'] ?? '—'),
                'fecha_evento' => now(),
                'user_id' => Auth::id(),
            ]);
        });

        // ✅ AUDITORÍA
        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Registro de mantenimiento de activo ID ' . $data['asset_id'] .
                        ' | Tipo ' . $data['tipo'] . ' | Estado ' . $data['estado'],
            'modulo'  => 'Mantenimientos',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Mantenimiento registrado y trazabilidad actualizada.');
    }
}
