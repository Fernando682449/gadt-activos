<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorías</h2>
            <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                Nueva Categoría
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if(session('success'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="text-gray-600">
                    Aquí irá la tabla con PowerGrid (Paso siguiente).
                </p>

            </div>
        </div>
    </div>
</x-app-layout>