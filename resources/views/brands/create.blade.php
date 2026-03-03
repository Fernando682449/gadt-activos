<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Nueva marca</h2>
                <p class="page-subtitle">Registra una marca para usarla al crear activos.</p>
            </div>

            <a href="{{ route('brands.index') }}" class="btn-ghost">Volver</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="card p-6">
                <form method="POST" action="{{ route('brands.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="label-pro">Nombre <span class="text-red-600">*</span></label>
                        <input name="name" value="{{ old('name') }}" class="input-pro" placeholder="Ej: Dell" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SOLO VISUAL (si quieres guardar, opción B) --}}
                    <div>
                        <label class="label-pro">Descripción (opcional)</label>
                        <textarea class="textarea-pro" rows="3" placeholder="Ej: Marca de equipos informáticos."></textarea>
                        <p class="mt-1 text-xs text-gray-500">Campo informativo (no se guarda aún).</p>
                    </div>

                    <div>
                        <label class="label-pro">Observación (opcional)</label>
                        <input class="input-pro" placeholder="Ej: Se usa para laptops y monitores" />
                        <p class="mt-1 text-xs text-gray-500">Campo informativo (no se guarda aún).</p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <a href="{{ route('brands.index') }}" class="btn-ghost">Cancelar</a>
                        <button type="submit" class="btn-brand">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>