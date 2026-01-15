<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\Custodian;
use App\Models\Location;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $assets = Asset::orderBy('codigo_patrimonial')->get();
        $custodians = Custodian::where('activo', 1)->orderBy('nombres')->get();
        $locations = Location::orderBy('name')->get();

        return view('assignments.create', compact('assets', 'custodians', 'locations'));
    }

    public function store(StoreAssignmentRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {

            Assignment::create([
                'asset_id' => $data['asset_id'],
                'custodian_id' => $data['custodian_id'],
                'location_id' => $data['location_id'],
                'tipo_movimiento' => $data['tipo_movimiento'],
                'fecha_asignacion' => $data['fecha_asignacion'],
                'observaciones' => $data['observaciones'] ?? null,
                'user_id' => Auth::id(),
            ]);

            $asset = Asset::findOrFail($data['asset_id']);
            $asset->update(['location_id' => $data['location_id']]);

            $custodian = Custodian::findOrFail($data['custodian_id']);
            $location = Location::findOrFail($data['location_id']);

            AssetHistory::create([
                'asset_id' => $asset->id,
                'evento' => $data['tipo_movimiento'],
                'detalle' => "Movimiento: {$data['tipo_movimiento']} | Custodio: {$custodian->nombre_completo} | Ubicación: {$location->name}",
                'fecha_evento' => now(),
                'user_id' => Auth::id(),
            ]);
        });

        // ✅ AUDITORÍA (después de la transacción)
        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Asignación/Reasignación de activo ID ' . $data['asset_id'] . ' a custodio ID ' . $data['custodian_id'],
            'modulo'  => 'Asignaciones',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Asignación registrada y trazabilidad generada.');
    }
}
