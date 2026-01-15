<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Location;
use App\Models\Status;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $assets = Asset::with(['type', 'status', 'location'])
            ->latest()
            ->paginate(10);

        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $types = AssetType::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('assets.create', compact('types', 'statuses', 'locations'));
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
        $asset->load(['type', 'status', 'location']);

        $histories = $asset->histories()
            ->with('user')
            ->orderByDesc('fecha_evento')
            ->get();

        $lastAssignment = $asset->assignments()
            ->with(['custodian', 'location'])
            ->latest()
            ->first();

        return view('assets.show', compact('asset', 'histories', 'lastAssignment'));
    }

    public function edit(Asset $asset)
    {
        $types = AssetType::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('assets.edit', compact('asset', 'types', 'statuses', 'locations'));
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
