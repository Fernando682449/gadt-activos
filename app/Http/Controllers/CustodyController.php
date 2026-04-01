<?php

namespace App\Http\Controllers;

use App\Models\Custodian;
use App\Models\Asset;
use App\Models\Assignment;
use App\Models\AssetHistory;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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

        return view('custody.index', compact('custodians', 'q'));
    }

    public function show(Custodian $custodian)
    {
        $assets = Asset::with([
                'type',
                'status',
                'location',
                'brand',
                'lastAssignment',
                'lastAssignmentEntrega'
            ])
            ->where('custodian_id', $custodian->id)
            ->orderBy('codigo_patrimonial')
            ->get();

        return view('custody.show', compact('custodian', 'assets'));
    }

    public function devolver(Request $request, Custodian $custodian, Asset $asset)
    {
        $request->validate([
            'location_id' => ['required', 'exists:locations,id'],
        ]);

        if ($asset->custodian_id !== $custodian->id) {
            return back()->with('error', 'Ese activo no pertenece a este custodio.');
        }

        $fecha = now()->format('Y-m-d');
        $assignment = null;

        DB::transaction(function () use ($request, $custodian, $asset, $fecha, &$assignment) {

            // 1) Registrar devolución
            $assignment = Assignment::create([
                'asset_id'         => $asset->id,
                'custodian_id'     => $custodian->id,
                'location_id'      => $request->location_id,
                'tipo_movimiento'  => 'DEVOLUCION',
                'fecha_asignacion' => $fecha,
                'observaciones'    => 'Devolución de activo a almacén/recepción',
                'user_id'          => Auth::id(),
            ]);

            // 2) Actualizar activo
            $asset->update([
                'custodian_id' => null,
                'location_id'  => $request->location_id,
            ]);

            // 3) Cargar relaciones necesarias
            $assignment->load([
                'asset.brand',
                'asset.type',
                'asset.status',
                'custodian',
                'location',
                'user'
            ]);

            $nombreCustodio = $custodian->nombre_completo
                ?? trim(($custodian->nombres ?? '') . ' ' . ($custodian->apellidos ?? ''));

            $codigoActivo = $assignment->asset->codigo_patrimonial ?? 'Sin código';
            $tipoActivo   = $assignment->asset->type?->name ?? 'Sin tipo';
            $marcaActivo  = $assignment->asset->brand?->name ?? 'Sin marca';
            $estadoActivo = $assignment->asset->status?->name ?? 'Sin estado';
            $ubicacion    = $assignment->location?->name ?? 'Sin ubicación';
            $usuario      = auth()->user()->name ?? 'Usuario del sistema';

            // 4) Guardar historial del activo con detalle completo
            AssetHistory::create([
                'asset_id'     => $asset->id,
                'evento'       => 'DEVOLUCION',
                'detalle'      => "Se registró la devolución del activo {$codigoActivo} ({$tipoActivo} - {$marcaActivo}, estado: {$estadoActivo}) que estaba bajo custodia de {$nombreCustodio}. El bien fue devuelto a la ubicación {$ubicacion}. Registro realizado por {$usuario}.",
                'fecha_evento' => now(),
                'user_id'      => Auth::id(),
            ]);

            // 5) Generar y guardar PDF
            $pdf = Pdf::loadView('pdf.acta-devolucion', [
                'a'       => $assignment,
                'usuario' => auth()->user(),
            ])->setPaper('A4');

            $filename = 'actas/acta_devolucion_' . $assignment->id . '_' . now()->format('Ymd_His') . '.pdf';

            Storage::disk('public')->put($filename, $pdf->output());

            $assignment->update([
                'acta_pdf_path' => $filename,
            ]);

            // 6) Historial de acciones detallado
            AuditLog::create([
                'user_id' => Auth::id(),
                'accion'  => "Se registró la devolución del activo {$codigoActivo} ({$tipoActivo} - {$marcaActivo}, estado: {$estadoActivo}) que estaba asignado a {$nombreCustodio}, con retorno a la ubicación {$ubicacion}. Operación realizada por {$usuario}.",
                'modulo'  => 'Custodia',
                'fecha'   => now(),
            ]);
        });

        // 7) Descargar automáticamente el PDF generado
        return response()->download(
            storage_path('app/public/' . $assignment->acta_pdf_path),
            'ACTA_DEVOLUCION_' . $assignment->id . '.pdf'
        );
    }
}