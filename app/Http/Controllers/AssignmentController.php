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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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

    
    public function actaPdf(\App\Models\Assignment $assignment)
{
    $assignment->load(['asset.brand','asset.type','custodian','location','user']);

    $pdf = Pdf::loadView('pdf.asignacion-acta', [
        'a' => $assignment,
        'usuario' => auth()->user(),
    ])->setPaper('A4');

    return $pdf->download('ACTA_ASIGNACION_'.$assignment->id.'.pdf');
}
    
    public function store(StoreAssignmentRequest $request)
{
    $data = $request->validated();

    DB::transaction(function () use ($data) {

        // 1) Crear asignación y GUARDAR en variable
        $assignment = Assignment::create([
            'asset_id'         => $data['asset_id'],
            'custodian_id'     => $data['custodian_id'],
            'location_id'      => $data['location_id'],
            'tipo_movimiento'  => $data['tipo_movimiento'],
            'fecha_asignacion' => $data['fecha_asignacion'],
            'observaciones'    => $data['observaciones'] ?? null,
            'user_id'          => Auth::id(),
        ]);

        // 2) Actualizar activo (AQUÍ es lo que te faltaba)
        $asset = Asset::findOrFail($data['asset_id']);

        if (in_array($data['tipo_movimiento'], ['ASIGNACION', 'REASIGNACION'])) {
            $asset->update([
                'custodian_id' => $data['custodian_id'],
                'location_id'  => $data['location_id'],
            ]);
        }

        if ($data['tipo_movimiento'] === 'TRASLADO') {
            $asset->update([
                'location_id' => $data['location_id'],
            ]);
        }

        // 3) Historial
        $custodian = Custodian::findOrFail($data['custodian_id']);
        $location  = Location::findOrFail($data['location_id']);

        AssetHistory::create([
            'asset_id'     => $asset->id,
            'evento'       => $data['tipo_movimiento'],
            'detalle'      => "Movimiento: {$data['tipo_movimiento']} | Custodio: {$custodian->nombre_completo} | Ubicación: {$location->name}",
            'fecha_evento' => now(),
            'user_id'      => Auth::id(),
        ]);

        // 4) Generar PDF del acta y guardarlo
        $assignment->load(['asset.brand','asset.type','custodian','location','user']);

        $pdf = Pdf::loadView('pdf.asignacion-acta', [
            'a' => $assignment,
            'usuario' => auth()->user(),
        ])->setPaper('A4');

        $filename = 'actas/acta_'.$assignment->id.'_'.Str::slug($assignment->tipo_movimiento).'_'.now()->format('Ymd_His').'.pdf';

        Storage::disk('public')->put($filename, $pdf->output());

        $assignment->update([
            'acta_pdf_path' => $filename
        ]);
    });

    // 5) Auditoría (afuera de la transacción)
    $activo = Asset::find($data['asset_id']);
    $custodio = Custodian::find($data['custodian_id']);
    AuditLog::create([
        'user_id' => Auth::id(),
        'accion'  => 'Asignación/Reasignación de activo (' . $activo->codigo_patrimonial . ') a custodio (' . $custodio->nombres . ' ' . $custodio->apellidos . ')',
        'modulo'  => 'Asignaciones',
        'fecha'   => now(),
    ]);

    return redirect()
        ->route('assets.index')
        ->with('success', 'Asignación registrada y trazabilidad generada.');
    }

    public function devolucionPdf(\App\Models\Assignment $assignment)
{
    $assignment->load(['asset.brand','asset.type','custodian','location','user']);

    $pdf = Pdf::loadView('pdf.devolucion-acta', [
        'a' => $assignment,
        'usuario' => auth()->user(),
    ])->setPaper('A4');

    return $pdf->download('ACTA_DEVOLUCION_'.$assignment->id.'.pdf');
}
}