<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Activo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <p><b>Código:</b> {{ $asset->codigo_patrimonial }}</p>
                <p><b>Serie:</b> {{ $asset->numero_serie ?? '—' }}</p>
                <p><b>Tipo:</b> {{ $asset->type?->name }}</p>
                <p><b>Estado:</b> {{ $asset->status?->name }}</p>
                <p><b>Ubicación:</b> {{ $asset->location?->name }}</p>
                <p><b>Fecha compra:</b> {{ $asset->fecha_compra ?? '—' }}</p>
                <p><b>Costo:</b> {{ $asset->costo ?? '—' }}</p>
                <p><b>Observaciones:</b> {{ $asset->observaciones ?? '—' }}</p>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('assets.index') }}" class="px-4 py-2 border rounded">Volver</a>
                    <a href="{{ route('assets.edit', $asset) }}" class="px-4 py-2 bg-yellow-600 text-border rounded">Editar</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
