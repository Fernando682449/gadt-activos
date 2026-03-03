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

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = Asset::with(['type', 'status', 'location', 'brand']);

        // 🔍 búsqueda por código o serie
        if (request('q')) {
            $q = request('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('codigo_patrimonial', 'like', "%{$q}%")
                    ->orWhere('numero_serie', 'like', "%{$q}%");
            });
        }

        // ✅ filtro por tipo (columna real: asset_type_id)
        if (request('asset_type_id')) {
            $query->where('asset_type_id', request('asset_type_id'));
        }

        // ✅ filtro por estado
        if (request('status_id')) {
            $query->where('status_id', request('status_id'));
        }

        // ✅ filtro por ubicación
        if (request('location_id')) {
            $query->where('location_id', request('location_id'));
        }

        // ✅ filtro por marca
        if (request('brand_id')) {
            $query->where('brand_id', request('brand_id'));
        }

        $assets = $query->latest()->paginate(10)->withQueryString();

        // combos para filtros
        $types = AssetType::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
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