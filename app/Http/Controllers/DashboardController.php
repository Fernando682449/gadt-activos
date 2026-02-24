<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Custodian;
use App\Models\Maintenance;
use App\Models\Status;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalAssets = Asset::count();
        $totalCustodians = Custodian::where('activo', 1)->count();
        $maintOpen = Maintenance::whereIn('estado', ['ABIERTO','EN_PROCESO'])->count();

        $statusActivo = Status::where('name', 'Activo')->first();
        $statusReparacion = Status::where('name', 'En reparación')->first();
        $statusBaja = Status::where('name', 'Baja')->first();

        $assetsActivos = $statusActivo ? Asset::where('status_id', $statusActivo->id)->count() : 0;
        $assetsReparacion = $statusReparacion ? Asset::where('status_id', $statusReparacion->id)->count() : 0;
        $assetsBaja = $statusBaja ? Asset::where('status_id', $statusBaja->id)->count() : 0;

        return view('dashboard', compact(
            'totalAssets','totalCustodians','maintOpen',
            'assetsActivos','assetsReparacion','assetsBaja'
        ));
    }
}
