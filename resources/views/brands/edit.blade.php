<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Editar Marca</h2>
                <p class="page-subtitle">Actualiza el nombre de la marca.</p>
            </div>

            <a href="{{ route('brands.index') }}" class="btn-ghost">Volver</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="card p-6">
                <form method="POST" action="{{ route('brands.update', $brand) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
    <label class="label-pro">Nombre *</label>
    <input name="name" value="{{ old('name', $brand->name) }}" class="input-pro">
</div>

<div>
    <label class="label-pro">Descripción</label>
    <input name="descripcion" value="{{ old('descripcion', $brand->descripcion) }}" class="input-pro">
</div>

<div>
    <label class="label-pro">Estado</label>
    <select name="activo" class="input-pro">
        <option value="1" {{ $brand->activo ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ !$brand->activo ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>

<div>
    <label class="label-pro">Observación</label>
    <textarea name="observacion" class="textarea-pro">{{ old('observacion', $brand->observacion) }}</textarea>
</div>
                    <div class="flex items-center justify-end gap-2 pt-2">
                        <a href="{{ route('brands.index') }}" class="btn-ghost">Cancelar</a>
                        <button type="submit" class="btn-brand">Guardar cambios</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>