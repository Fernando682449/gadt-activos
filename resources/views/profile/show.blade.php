<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">
                    Perfil
                </h2>
                <p class="text-sm text-gray-600">
                    Administra tu información, seguridad y sesiones activas.
                </p>
            </div>

            <div class="hidden sm:flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                    {{ Auth::user()->getRoleNames()->first() ?? 'Usuario' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Fondo suave --}}
            <div class="rounded-2xl p-6 sm:p-8 bg-white/80 backdrop-blur shadow-sm border border-gray-200">

                {{-- ✅ Información de perfil --}}
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                        @livewire('profile.update-profile-information-form')
                    </div>

                    <div class="my-8 border-t border-gray-200"></div>
                @endif

                {{-- ✅ Cambiar contraseña --}}
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                        @livewire('profile.update-password-form')
                    </div>

                    <div class="my-8 border-t border-gray-200"></div>
                @endif

                {{-- ✅ 2FA (si lo usas) --}}
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                        @livewire('profile.two-factor-authentication-form')
                    </div>

                    <div class="my-8 border-t border-gray-200"></div>
                @endif

                {{-- ✅ Cerrar sesiones --}}
                <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                {{-- ✅ Eliminar cuenta (si está habilitado) --}}
                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div class="my-8 border-t border-gray-200"></div>

                    <div class="rounded-2xl bg-white border border-red-200 shadow-sm p-6">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>