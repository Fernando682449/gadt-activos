<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bitácora / Auditoría
        </h2>
        <center><a href="{{ route('reports.auditlogs.pdf', request()->query()) }}"
   class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-black">
    Exportar PDF
</a></center>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- DEBUG: muestra cuántos logs llegan --}}
                    <p class="text-sm text-gray-500 mb-3">
                        Total registros cargados: {{ $logs->count() }}
                    </p>

                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Fecha</th>
                                <th class="text-left py-2">Usuario</th>
                                <th class="text-left py-2">Módulo</th>
                                <th class="text-left py-2">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($logs as $log)
                                <tr class="border-b">
                                    <td class="py-2">{{ $log->fecha }}</td>
                                    <td class="py-2">{{ $log->user?->name ?? '—' }}</td>
                                    <td class="py-2">{{ $log->modulo }}</td>
                                    <td class="py-2">{{ $log->accion }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">
                                        No hay registros en bitácora.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
