<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\AssetStatus;
use App\Models\Location;
use App\Models\Brand;
use App\Models\Custodian;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with(['type', 'status', 'location', 'brand', 'custodian']);

        if ($request->filled('q')) {
            $q = trim($request->q);

            $query->where(function ($sub) use ($q) {
                $sub->where('codigo_patrimonial', 'like', "%{$q}%")
                    ->orWhere('numero_serie', 'like', "%{$q}%")
                    ->orWhere('nro_factura', 'like', "%{$q}%")
                    ->orWhere('observaciones', 'like', "%{$q}%")
                    ->orWhereHas('type', function ($t) use ($q) {
                        $t->where('name', 'like', "%{$q}%")
                          ->orWhere('description', 'like', "%{$q}%");
                    })
                    ->orWhereHas('brand', function ($b) use ($q) {
                        $b->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('custodian', function ($c) use ($q) {
                        $c->where('nombres', 'like', "%{$q}%")
                          ->orWhere('apellidos', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('asset_type_id')) {
            $query->where('asset_type_id', $request->asset_type_id);
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $assets = $query->latest()->paginate(10)->withQueryString();

        $types = AssetType::orderBy('name')->get();
        $statuses = AssetStatus::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('assets.index', compact('assets', 'types', 'statuses', 'locations', 'brands'));
    }

    public function create()
    {
        $types = AssetType::orderBy('name')->get();
        $statuses = AssetStatus::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $custodians = Custodian::orderBy('apellidos')->orderBy('nombres')->get();

        return view('assets.create', compact(
            'types',
            'statuses',
            'locations',
            'brands',
            'custodians'
        ));
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create($request->validated());
        $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => "Se registró el activo {$asset->codigo_patrimonial} ({$this->assetTypeName($asset)} - {$this->assetBrandName($asset)}), con estado {$this->assetStatusName($asset)}, ubicación {$this->assetLocationName($asset)} y responsable {$this->assetCustodianName($asset)}. Serie: {$this->safeText($asset->numero_serie)}. Factura: {$this->safeText($asset->nro_factura)}. Observaciones: {$this->safeText($asset->observaciones)}. Operación realizada por {$this->currentUserName()}.",
            'modulo'  => 'Activos',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Activo registrado correctamente.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

        $movimientos = $asset->assignments()
            ->with(['custodian', 'location', 'user'])
            ->latest('fecha_asignacion')
            ->get();

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => "Se visualizó el detalle del activo {$asset->codigo_patrimonial} ({$this->assetTypeName($asset)} - {$this->assetBrandName($asset)}), estado {$this->assetStatusName($asset)}, ubicación {$this->assetLocationName($asset)}, responsable {$this->assetCustodianName($asset)} y factura {$this->safeText($asset->nro_factura)}. Acción realizada por {$this->currentUserName()}.",
            'modulo'  => 'Activos',
            'fecha'   => now(),
        ]);

        return view('assets.show', compact('asset', 'movimientos'));
    }

    public function edit(Asset $asset)
    {
        $types = AssetType::orderBy('name')->get();
        $statuses = AssetStatus::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $custodians = Custodian::orderBy('apellidos')->orderBy('nombres')->get();

        return view('assets.edit', compact(
            'asset',
            'types',
            'statuses',
            'locations',
            'brands',
            'custodians'
        ));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

        $antes = [
            'codigo_patrimonial' => $asset->codigo_patrimonial,
            'numero_serie'       => $asset->numero_serie,
            'nro_factura'        => $asset->nro_factura,
            'tipo'               => $this->assetTypeName($asset),
            'estado'             => $this->assetStatusName($asset),
            'ubicacion'          => $this->assetLocationName($asset),
            'marca'              => $this->assetBrandName($asset),
            'responsable'        => $this->assetCustodianName($asset),
            'observaciones'      => $this->safeText($asset->observaciones),
        ];

        $asset->update($request->validated());
        $asset->refresh();
        $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

        $despues = [
            'codigo_patrimonial' => $asset->codigo_patrimonial,
            'numero_serie'       => $asset->numero_serie,
            'nro_factura'        => $asset->nro_factura,
            'tipo'               => $this->assetTypeName($asset),
            'estado'             => $this->assetStatusName($asset),
            'ubicacion'          => $this->assetLocationName($asset),
            'marca'              => $this->assetBrandName($asset),
            'responsable'        => $this->assetCustodianName($asset),
            'observaciones'      => $this->safeText($asset->observaciones),
        ];

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => "Se actualizó el activo {$antes['codigo_patrimonial']}. Antes: tipo {$antes['tipo']}, estado {$antes['estado']}, ubicación {$antes['ubicacion']}, marca {$antes['marca']}, responsable {$antes['responsable']}, serie {$this->safeText($antes['numero_serie'])}, factura {$this->safeText($antes['nro_factura'])}, observaciones {$antes['observaciones']}. Después: tipo {$despues['tipo']}, estado {$despues['estado']}, ubicación {$despues['ubicacion']}, marca {$despues['marca']}, responsable {$despues['responsable']}, serie {$this->safeText($despues['numero_serie'])}, factura {$this->safeText($despues['nro_factura'])}, observaciones {$despues['observaciones']}. Operación realizada por {$this->currentUserName()}.",
            'modulo'  => 'Activos',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Activo actualizado correctamente.');
    }

    public function destroy(Asset $asset)
{
    $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

    $estadoAnterior = $this->assetStatusName($asset);
    $responsable = $this->assetCustodianName($asset);
    $ubicacion = $this->assetLocationName($asset);
    $tipo = $this->assetTypeName($asset);
    $marca = $this->assetBrandName($asset);

    $statusBaja = AssetStatus::where('name', 'Baja')->first();

    if (!$statusBaja) {
        return redirect()
            ->route('assets.index')
            ->with('error', 'No existe el estado "Baja" en la tabla asset_statuses.');
    }

    $asset->update([
        'status_id' => $statusBaja->id,
        'fecha_baja' => now()->toDateString(),
    ]);

    $asset->refresh();
    $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

    AuditLog::create([
        'user_id' => Auth::id(),
        'accion'  => "Se dio de baja el activo {$asset->codigo_patrimonial} ({$tipo} - {$marca}), que se encontraba con estado {$estadoAnterior}, ubicación {$ubicacion}, responsable {$responsable}, factura {$this->safeText($asset->nro_factura)} y fecha de baja {$asset->fecha_baja}. Estado actual: {$this->assetStatusName($asset)}. Operación realizada por {$this->currentUserName()}.",
        'modulo'  => 'Activos',
        'fecha'   => now(),
    ]);

    return redirect()
        ->route('assets.index')
        ->with('success', 'Activo dado de baja correctamente.');
}

    public function exportPdf()
    {
        $assets = Asset::with(['type', 'status', 'location', 'brand', 'custodian'])
            ->orderBy('codigo_patrimonial')
            ->get();

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Se exportó el reporte general de activos en PDF. Operación realizada por ' . $this->currentUserName() . '.',
            'modulo'  => 'Activos',
            'fecha'   => now(),
        ]);

        $pdf = Pdf::loadView('pdf.assets-report', compact('assets'))->setPaper('A4', 'landscape');

        return $pdf->download('reporte_activos.pdf');
    }


    public function reporteAltasBajasPorFecha(Request $request)
{
    $request->validate([
        'fecha_inicio' => ['nullable', 'date'],
        'fecha_fin'    => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        'q'            => ['nullable', 'string', 'max:100'],
    ], [
        'fecha_inicio.date' => 'La fecha inicial no es válida.',
        'fecha_fin.date' => 'La fecha final no es válida.',
        'fecha_fin.after_or_equal' => 'La fecha final debe ser mayor o igual a la fecha inicial.',
        'q.max' => 'La búsqueda no debe superar 100 caracteres.',
    ]);

    $fechaInicio = $request->fecha_inicio;
    $fechaFin = $request->fecha_fin;
    $q = trim((string) $request->q);

    $altasQuery = Asset::with(['type', 'status', 'location', 'brand', 'custodian']);
    $bajasQuery = Asset::with(['type', 'status', 'location', 'brand', 'custodian'])
        ->whereNotNull('fecha_baja');

    if ($fechaInicio) {
        $altasQuery->whereDate('created_at', '>=', $fechaInicio);
        $bajasQuery->whereDate('fecha_baja', '>=', $fechaInicio);
    }

    if ($fechaFin) {
        $altasQuery->whereDate('created_at', '<=', $fechaFin);
        $bajasQuery->whereDate('fecha_baja', '<=', $fechaFin);
    }

    if ($q !== '') {
        $altasQuery->where(function ($sub) use ($q) {
            $sub->where('codigo_patrimonial', 'like', "%{$q}%")
                ->orWhere('numero_serie', 'like', "%{$q}%")
                ->orWhere('nro_factura', 'like', "%{$q}%")
                ->orWhereHas('type', function ($t) use ($q) {
                    $t->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('brand', function ($b) use ($q) {
                    $b->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('location', function ($l) use ($q) {
                    $l->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('custodian', function ($c) use ($q) {
                    $c->where('nombres', 'like', "%{$q}%")
                      ->orWhere('apellidos', 'like', "%{$q}%");
                });
        });

        $bajasQuery->where(function ($sub) use ($q) {
            $sub->where('codigo_patrimonial', 'like', "%{$q}%")
                ->orWhere('numero_serie', 'like', "%{$q}%")
                ->orWhere('nro_factura', 'like', "%{$q}%")
                ->orWhereHas('type', function ($t) use ($q) {
                    $t->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('brand', function ($b) use ($q) {
                    $b->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('location', function ($l) use ($q) {
                    $l->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('custodian', function ($c) use ($q) {
                    $c->where('nombres', 'like', "%{$q}%")
                      ->orWhere('apellidos', 'like', "%{$q}%");
                });
        });
    }

    $altas = $altasQuery->orderBy('created_at', 'desc')->get();
    $bajas = $bajasQuery->orderBy('fecha_baja', 'desc')->get();

    AuditLog::create([
        'user_id' => Auth::id(),
        'accion'  => 'Se consultó el reporte de altas y bajas por fecha. ' .
                     'Rango: ' . ($fechaInicio ?: 'sin fecha inicial') . ' a ' . ($fechaFin ?: 'sin fecha final') .
                     '. Búsqueda: ' . ($q !== '' ? $q : 'sin texto') .
                     '. Altas encontradas: ' . $altas->count() .
                     '. Bajas encontradas: ' . $bajas->count() .
                     '. Operación realizada por ' . $this->currentUserName() . '.',
        'modulo'  => 'Activos',
        'fecha'   => now(),
    ]);

    return view('reports.altas-bajas-fecha', compact(
        'altas',
        'bajas',
        'fechaInicio',
        'fechaFin',
        'q'
    ));
}


public function reporteAltasBajasPorFechaPdf(Request $request)
{
    $request->validate([
        'fecha_inicio' => ['nullable', 'date'],
        'fecha_fin'    => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        'q'            => ['nullable', 'string', 'max:100'],
    ], [
        'fecha_inicio.date' => 'La fecha inicial no es válida.',
        'fecha_fin.date' => 'La fecha final no es válida.',
        'fecha_fin.after_or_equal' => 'La fecha final debe ser mayor o igual a la fecha inicial.',
        'q.max' => 'La búsqueda no debe superar 100 caracteres.',
    ]);

    $fechaInicio = $request->fecha_inicio;
    $fechaFin = $request->fecha_fin;
    $q = trim((string) $request->q);

    $altasQuery = Asset::with(['type', 'status', 'location', 'brand', 'custodian']);
    $bajasQuery = Asset::with(['type', 'status', 'location', 'brand', 'custodian'])
        ->whereNotNull('fecha_baja');

    if ($fechaInicio) {
        $altasQuery->whereDate('created_at', '>=', $fechaInicio);
        $bajasQuery->whereDate('fecha_baja', '>=', $fechaInicio);
    }

    if ($fechaFin) {
        $altasQuery->whereDate('created_at', '<=', $fechaFin);
        $bajasQuery->whereDate('fecha_baja', '<=', $fechaFin);
    }

    if ($q !== '') {
        $altasQuery->where(function ($sub) use ($q) {
            $sub->where('codigo_patrimonial', 'like', "%{$q}%")
                ->orWhere('numero_serie', 'like', "%{$q}%")
                ->orWhere('nro_factura', 'like', "%{$q}%")
                ->orWhereHas('type', function ($t) use ($q) {
                    $t->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('brand', function ($b) use ($q) {
                    $b->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('location', function ($l) use ($q) {
                    $l->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('custodian', function ($c) use ($q) {
                    $c->where('nombres', 'like', "%{$q}%")
                      ->orWhere('apellidos', 'like', "%{$q}%");
                });
        });

        $bajasQuery->where(function ($sub) use ($q) {
            $sub->where('codigo_patrimonial', 'like', "%{$q}%")
                ->orWhere('numero_serie', 'like', "%{$q}%")
                ->orWhere('nro_factura', 'like', "%{$q}%")
                ->orWhereHas('type', function ($t) use ($q) {
                    $t->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('brand', function ($b) use ($q) {
                    $b->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('location', function ($l) use ($q) {
                    $l->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('custodian', function ($c) use ($q) {
                    $c->where('nombres', 'like', "%{$q}%")
                      ->orWhere('apellidos', 'like', "%{$q}%");
                });
        });
    }

    $altas = $altasQuery->orderBy('created_at', 'desc')->get();
    $bajas = $bajasQuery->orderBy('fecha_baja', 'desc')->get();

    AuditLog::create([
        'user_id' => Auth::id(),
        'accion'  => 'Se exportó el reporte PDF de altas y bajas por fecha. ' .
                     'Rango: ' . ($fechaInicio ?: 'sin fecha inicial') . ' a ' . ($fechaFin ?: 'sin fecha final') .
                     '. Búsqueda: ' . ($q !== '' ? $q : 'sin texto') .
                     '. Altas encontradas: ' . $altas->count() .
                     '. Bajas encontradas: ' . $bajas->count() .
                     '. Operación realizada por ' . $this->currentUserName() . '.',
        'modulo'  => 'Activos',
        'fecha'   => now(),
    ]);

    $pdf = Pdf::loadView('pdf.altas-bajas-fecha', compact(
        'altas',
        'bajas',
        'fechaInicio',
        'fechaFin',
        'q'
    ))->setPaper('A4', 'landscape');

    return $pdf->download('reporte_altas_bajas_por_fecha.pdf');
}

    public function altaPdf(Asset $asset)
{
    $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

    AuditLog::create([
        'user_id' => Auth::id(),
        'accion'  => "Se descargó el acta PDF del activo {$asset->codigo_patrimonial} ({$this->assetTypeName($asset)} - {$this->assetBrandName($asset)}), estado {$this->assetStatusName($asset)}, ubicación {$this->assetLocationName($asset)}, responsable {$this->assetCustodianName($asset)}, serie {$this->safeText($asset->numero_serie)}, fecha de compra {$this->safeText($asset->fecha_compra)}, costo {$this->safeText($asset->costo)} y factura {$this->safeText($asset->nro_factura)}. Operación realizada por {$this->currentUserName()}.",
        'modulo'  => 'Activos',
        'fecha'   => now(),
    ]);

    $pdf = Pdf::loadView('pdf.acta-alta-activo', [
        'asset'   => $asset,
        'usuario' => auth()->user(),
    ])->setPaper('A4');

    return $pdf->download('ACTA_ALTA_' . $asset->codigo_patrimonial . '.pdf');
}

    private function assetTypeName(Asset $asset): string
    {
        return $asset->type?->name ?? 'Sin tipo';
    }

    private function assetStatusName(Asset $asset): string
    {
        return $asset->status?->name ?? 'Sin estado';
    }

    private function assetLocationName(Asset $asset): string
    {
        return $asset->location?->name ?? 'Sin ubicación';
    }

    private function assetBrandName(Asset $asset): string
    {
        return $asset->brand?->name ?? 'Sin marca';
    }

    private function assetCustodianName(Asset $asset): string
    {
        if ($asset->custodian) {
            return $asset->custodian->nombre_completo
                ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? ''));
        }

        return 'Sin responsable asignado';
    }

    private function currentUserName(): string
    {
        return auth()->user()->name ?? 'Usuario del sistema';
    }

    private function safeText($value): string
    {
        return filled($value) ? (string) $value : 'Sin dato';
    }
}