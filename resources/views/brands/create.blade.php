<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Marca</h2>
            <a href="{{ route('brands.index') }}" class="px-4 py-2 bg-gray-200 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('brands.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name"
                               class="mt-1 block w-full rounded border-gray-300"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full rounded border-gray-300"></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('brands.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancelar</a>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>