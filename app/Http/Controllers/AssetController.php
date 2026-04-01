<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\AssetStatus;
use App\Models\Location;
use App\Models\Status;
use App\Models\AuditLog;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class AssetController extends Controller
{
    public function index()
{
    $query = Asset::with(['type', 'status', 'location', 'brand', 'custodian']);

    // búsqueda mejorada
    if (request('q')) {
        $q = trim(request('q'));

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

    if (request('asset_type_id')) {
        $query->where('asset_type_id', request('asset_type_id'));
    }

    if (request('status_id')) {
        $query->where('status_id', request('status_id'));
    }

    if (request('location_id')) {
        $query->where('location_id', request('location_id'));
    }

    if (request('brand_id')) {
        $query->where('brand_id', request('brand_id'));
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
        $brands = \App\Models\Brand::orderBy('name')->get();

        return view('assets.create', compact('types', 'statuses', 'locations', 'brands'));
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create($request->validated());

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Registro de activo: ' . $asset->codigo_patrimonial,
            'modulo'  => 'Activos',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Activo registrado correctamente.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['type', 'status', 'location', 'brand']);

        $histories = $asset->histories()
            ->with('user')
            ->orderByDesc('fecha_evento')
            ->get();

        $lastAssignment = $asset->assignments()
            ->with(['custodian', 'location'])
            ->latest()
            ->first();

        $movimientos = $asset->assignments()
        ->with(['custodian','location'])
        ->orderByDesc('fecha_asignacion')
        ->get();

        return view('assets.show', compact('asset', 'histories', 'lastAssignment', 'movimientos'));
    }

    public function edit(Asset $asset)
    {
        $types = AssetType::orderBy('name')->get();
        $statuses = AssetStatus::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $brands = \App\Models\Brand::orderBy('name')->get();

        return view('assets.edit', compact('asset', 'types', 'statuses', 'locations', 'brands'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Actualización de activo: ' . $asset->codigo_patrimonial,
            'modulo'  => 'Activos',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Activo actualizado correctamente.');
    }

    public function altaPdf(\App\Models\Asset $asset)
{
    $asset->load(['type','status','location','brand']);

    $pdf = Pdf::loadView('pdf.activo-alta', [
        'asset' => $asset,
        'usuario' => auth()->user(),
    ])->setPaper('A4');

    return $pdf->download('ACTA_ALTA_'.$asset->codigo_patrimonial.'.pdf');
}

    public function destroy(Asset $asset)
    {
        $statusBaja = Status::where('name', 'Baja')->first();

        if ($statusBaja) {
            $asset->update(['status_id' => $statusBaja->id]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'accion'  => 'Baja de activo: ' . $asset->codigo_patrimonial,
                'modulo'  => 'Activos',
                'fecha'   => now(),
            ]);
        }

        return redirect()
            ->route('assets.index')
            ->with('success', 'Activo dado de baja correctamente.');
    }
}