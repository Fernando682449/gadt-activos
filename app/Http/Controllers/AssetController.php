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
            'accion'  => "Se registró el activo {$asset->codigo_patrimonial} ({$this->assetTypeName($asset)} - {$this->assetBrandName($asset)}), con estado {$this->assetStatusName($asset)}, ubicación {$this->assetLocationName($asset)} y responsable {$this->assetCustodianName($asset)}. Serie: {$this->safeText($asset->numero_serie)}. Observaciones: {$this->safeText($asset->observaciones)}. Operación realizada por {$this->currentUserName()}.",
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
            'accion'  => "Se visualizó el detalle del activo {$asset->codigo_patrimonial} ({$this->assetTypeName($asset)} - {$this->assetBrandName($asset)}), estado {$this->assetStatusName($asset)}, ubicación {$this->assetLocationName($asset)} y responsable {$this->assetCustodianName($asset)}. Acción realizada por {$this->currentUserName()}.",
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
            'tipo'               => $this->assetTypeName($asset),
            'estado'             => $this->assetStatusName($asset),
            'ubicacion'          => $this->assetLocationName($asset),
            'marca'              => $this->assetBrandName($asset),
            'responsable'        => $this->assetCustodianName($asset),
            'observaciones'      => $this->safeText($asset->observaciones),
        ];

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => "Se actualizó el activo {$antes['codigo_patrimonial']}. Antes: tipo {$antes['tipo']}, estado {$antes['estado']}, ubicación {$antes['ubicacion']}, marca {$antes['marca']}, responsable {$antes['responsable']}, serie {$antes['numero_serie']}, observaciones {$antes['observaciones']}. Después: tipo {$despues['tipo']}, estado {$despues['estado']}, ubicación {$despues['ubicacion']}, marca {$despues['marca']}, responsable {$despues['responsable']}, serie {$despues['numero_serie']}, observaciones {$despues['observaciones']}. Operación realizada por {$this->currentUserName()}.",
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
        ]);

        $asset->refresh();
        $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => "Se dio de baja el activo {$asset->codigo_patrimonial} ({$tipo} - {$marca}), que se encontraba con estado {$estadoAnterior}, ubicación {$ubicacion} y responsable {$responsable}. Estado actual: {$this->assetStatusName($asset)}. Operación realizada por {$this->currentUserName()}.",
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

    public function altaPdf(Asset $asset)
{
    $asset->load(['type', 'status', 'location', 'brand', 'custodian']);

    AuditLog::create([
        'user_id' => Auth::id(),
        'accion'  => "Se descargó el acta PDF del activo {$asset->codigo_patrimonial} ({$this->assetTypeName($asset)} - {$this->assetBrandName($asset)}), estado {$this->assetStatusName($asset)}, ubicación {$this->assetLocationName($asset)} y responsable {$this->assetCustodianName($asset)}. Operación realizada por {$this->currentUserName()}.",
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