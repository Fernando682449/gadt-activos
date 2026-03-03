<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $brands = Brand::query()
            ->when($q, fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('brands.index', compact('brands', 'q'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:brands,name'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Esa marca ya existe.',
        ]);

        Brand::create($data);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Marca registrada correctamente.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:brands,name,' . $brand->id],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Esa marca ya existe.',
        ]);

        $brand->update($data);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Marca actualizada correctamente.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->with('success', 'Marca eliminada correctamente.');
    }
}