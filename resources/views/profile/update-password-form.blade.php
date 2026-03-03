<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Cambiar contraseña') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Asegúrate de utilizar una contraseña larga, segura y difícil de adivinar para proteger tu cuenta.') }}
    </x-slot>

    <x-slot name="form">

        {{-- Contraseña actual --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Contraseña actual') }}" />
            <x-input id="current_password"
                     type="password"
                     class="mt-1 block w-full rounded-xl focus:ring-red-500 focus:border-red-500"
                     wire:model="state.current_password"
                     autocomplete="current-password"
                     placeholder="Ingresa tu contraseña actual" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        {{-- Nueva contraseña --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('Nueva contraseña') }}" />
            <x-input id="password"
                     type="password"
                     class="mt-1 block w-full rounded-xl focus:ring-red-500 focus:border-red-500"
                     wire:model="state.password"
                     autocomplete="new-password"
                     placeholder="Nueva contraseña segura" />
            <x-input-error for="password" class="mt-2" />
        </div>

        {{-- Confirmar contraseña --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirmar nueva contraseña') }}" />
            <x-input id="password_confirmation"
                     type="password"
                     class="mt-1 block w-full rounded-xl focus:ring-red-500 focus:border-red-500"
                     wire:model="state.password_confirmation"
                     autocomplete="new-password"
                     placeholder="Repite la nueva contraseña" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3 text-emerald-700 font-semibold" on="saved">
            {{ __('Contraseña actualizada correctamente.') }}
        </x-action-message>

        <x-button class="rounded-xl px-6 bg-red-600 hover:bg-red-700">
            {{ __('Actualizar contraseña') }}
        </x-button>
    </x-slot>
</x-form-section>