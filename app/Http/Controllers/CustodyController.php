<?php

namespace App\Http\Controllers;

use App\Models\Custodian;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\AssetHistory;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Location;



class CustodyController extends Controller
{
   public function index(Request $request)
{
    $q = $request->get('q');

    $custodians = Custodian::query()
        ->when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nombres', 'like', "%{$q}%")
                    ->orWhere('apellidos', 'like', "%{$q}%")
                    ->orWhere('cargo', 'like', "%{$q}%")
                    ->orWhere('unidad', 'like', "%{$q}%");
            });
        })
        ->withCount(['assets as activos_en_custodia'])
        ->orderBy('apellidos')
        ->paginate(10);

    return view('custody.index', compact('custodians','q'));
}

    public function show(Custodian $custodian)
    {
        $assets = Asset::with(['type','status','location','brand','lastAssignment', 'lastAssignmentEntrega'])
            ->where('custodian_id', $custodian->id)
            ->orderBy('codigo_patrimonial')
            ->get();

        return view('custody.show', compact('custodian','assets'));
    }

    public function devolver(Request $request, Custodian $custodian, Asset $asset)
{
    $request->validate([
        'location_id' => ['required', 'exists:locations,id'],
    ]);

    // Seguridad: que el activo realmente esté asignado a ese custodio
    if ($asset->custodian_id !== $custodian->id) {
        return back()->with('error', 'Ese activo no pertenece a este custodio.');
    }

    $fecha = now()->format('Y-m-d');

    DB::transaction(function () use ($request, $custodian, $asset, $fecha) {

        // 1) Crear registro en assignments como DEVOLUCION
        $assignment = Assignment::create([
            'asset_id' => $asset->id,
            'custodian_id' => $custodian->id,
            'location_id' => $request->location_id,
            'tipo_movimiento' => 'DEVOLUCION',
            'fecha_asignacion' => $fecha,
            'observaciones' => 'Devolución de activo a almacén/recepción',
            'user_id' => Auth::id(),
        ]);

        // 2) Actualizar activo: ya no está en custodia
        $asset->update([
            'custodian_id' => null,
            'location_id' => $request->location_id,
        ]);

        // 3) Guardar historial
        AssetHistory::create([
            'asset_id' => $asset->id,
            'evento' => 'DEVOLUCION',
            'detalle' => "Devolución | Custodio: {$custodian->nombre_completo}",
            'fecha_evento' => now(),
            'user_id' => Auth::id(),
        ]);

        // 4) Generar PDF de devolución y guardarlo en storage/public
        $assignment->load(['asset.brand','asset.type','custodian','location','user']);

        $pdf = Pdf::loadView('pdf.acta-devolucion', [
            'a' => $assignment,
            'usuario' => auth()->user(),
        ])->setPaper('A4');

        $filename = 'actas/acta_devolucion_'.$assignment->id.'_'.now()->format('Ymd_His').'.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        $assignment->update([
            'acta_pdf_path' => $filename,
        ]);

        // Auditoría
        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Devolución de activo ID ' . $asset->id . ' del custodio ID ' . $custodian->id,
            'modulo'  => 'Custodia',
            'fecha'   => now(),
        ]);
    });

    return redirect()
        ->route('custody.show', $custodian)
        ->with('success', 'Devolución registrada y acta generada.');
}
}
