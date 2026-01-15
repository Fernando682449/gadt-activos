<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Custodio
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <p><b>Nombre:</b> {{ $custodian->nombre_completo }}</p>
                <p><b>Cargo:</b> {{ $custodian->cargo ?? '—' }}</p>
                <p><b>Unidad:</b> {{ $custodian->unidad ?? '—' }}</p>
                <p><b>Email:</b> {{ $custodian->email ?? '—' }}</p>
                <p><b>Estado:</b> {{ $custodian->activo ? 'Activo' : 'Inactivo' }}</p>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('custodians.index') }}" class="px-4 py-2 border rounded">Volver</a>
                    <a href="{{ route('custodians.edit', $custodian) }}" class="px-4 py-2 bg-yellow-600 text-border rounded">
                        Editar
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
