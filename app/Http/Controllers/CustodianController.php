<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustodianRequest;
use App\Http\Requests\UpdateCustodianRequest;
use App\Models\Custodian;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class CustodianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $custodians = Custodian::orderBy('nombres')->paginate(10);
        return view('custodians.index', compact('custodians'));
    }

    public function create()
    {
        return view('custodians.create');
    }

    public function store(StoreCustodianRequest $request)
    {
        $custodian = Custodian::create($request->validated());

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Registro de custodio: ' . $custodian->nombre_completo,
            'modulo'  => 'Custodios',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('custodians.index')
            ->with('success', 'Custodio creado correctamente.');
    }

    public function show(Custodian $custodian)
    {
        return view('custodians.show', compact('custodian'));
    }

    public function edit(Custodian $custodian)
    {
        return view('custodians.edit', compact('custodian'));
    }

    public function update(UpdateCustodianRequest $request, Custodian $custodian)
    {
        $custodian->update($request->validated());

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Actualización de custodio: ' . $custodian->nombre_completo,
            'modulo'  => 'Custodios',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('custodians.index')
            ->with('success', 'Custodio actualizado correctamente.');
    }

    public function destroy(Custodian $custodian)
    {
        $custodian->update(['activo' => false]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'accion'  => 'Desactivación de custodio: ' . $custodian->nombre_completo,
            'modulo'  => 'Custodios',
            'fecha'   => now(),
        ]);

        return redirect()
            ->route('custodians.index')
            ->with('success', 'Custodio desactivado correctamente.');
    }
}
