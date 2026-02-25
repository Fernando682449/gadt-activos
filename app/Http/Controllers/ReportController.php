<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Asset;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function assetsPdf(Request $request)
    {
        $query = Asset::with(['type', 'status', 'location', 'brand']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('codigo_patrimonial', 'like', "%{$q}%")
                    ->orWhere('numero_serie', 'like', "%{$q}%");
            });
        }

        if ($request->filled('asset_type_id')) $query->where('asset_type_id', $request->asset_type_id);
        if ($request->filled('status_id'))     $query->where('status_id', $request->status_id);
        if ($request->filled('location_id'))   $query->where('location_id', $request->location_id);
        if ($request->filled('brand_id'))      $query->where('brand_id', $request->brand_id);

        // En PDF normalmente conviene sin paginación
        $assets = $query->orderByDesc('id')->get();

        $filters = $request->only(['q','asset_type_id','status_id','location_id','brand_id']);

        $pdf = Pdf::loadView('reports.assets-pdf', compact('assets', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('reporte_activos.pdf');
    }
    public function custodiansPdf(Request $request)
{
    $query = Custodian::query();

    // Si tu listado tiene búsqueda, aquí la copiamos
    // Ajusta los campos si tu tabla usa otros nombres
    if ($request->filled('q')) {
        $q = $request->q;
        $query->where(function ($sub) use ($q) {
            $sub->where('name', 'like', "%{$q}%")
                ->orWhere('ci', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%");
        });
    }

}

public function auditLogsPdf(Request $request)
{
    $query = AuditLog::with('user'); // si tu AuditLog tiene relación user()

    // filtros típicos (ajusta según tu bitácora)
    if ($request->filled('q')) {
        $q = $request->q;
        $query->where(function ($sub) use ($q) {
            $sub->where('accion', 'like', "%{$q}%")
                ->orWhere('modulo', 'like', "%{$q}%");
        });
    }

    // rango por fechas si lo quieres (opcional)
    if ($request->filled('from')) {
        $query->whereDate('fecha', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $query->whereDate('fecha', '<=', $request->to);
    }

    $logs = $query->orderByDesc('fecha')->get();

    $pdf = Pdf::loadView('reports.auditlogs-pdf', compact('logs'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('reporte_bitacora.pdf');
}
}