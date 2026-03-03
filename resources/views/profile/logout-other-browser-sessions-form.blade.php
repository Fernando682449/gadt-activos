<x-action-section>
    <x-slot name="title">
        {{ __('Sesiones activas') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Administra y cierra las sesiones activas en otros navegadores y dispositivos.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 leading-relaxed">
            {{ __('Si lo necesitas, puedes cerrar sesión en todos los demás navegadores y dispositivos donde tu cuenta esté abierta. Abajo se muestran algunas sesiones recientes; esta lista puede no incluir todas. Si crees que tu cuenta fue comprometida, también se recomienda cambiar tu contraseña.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-6 space-y-4">
                <!-- Otras sesiones -->
                @foreach ($this->sessions as $session)
                    <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                        <div class="shrink-0 h-11 w-11 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-center">
                            @if ($session->agent->isDesktop())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Desconocido') }}
                                <span class="text-gray-300 px-1">•</span>
                                {{ $session->agent->browser() ? $session->agent->browser() : __('Desconocido') }}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                <span class="font-medium text-gray-600">{{ $session->ip_address }}</span>
                                <span class="text-gray-300 px-1">•</span>

                                @if ($session->is_current_device)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ __('Este dispositivo') }}
                                    </span>
                                @else
                                    {{ __('Última actividad') }}: {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center gap-3 mt-6">
            <x-button wire:click="confirmLogout" wire:loading.attr="disabled" class="rounded-xl">
                {{ __('Cerrar sesión en otros dispositivos') }}
            </x-button>

            <x-action-message class="ms-1 text-emerald-700 font-semibold" on="loggedOut">
                {{ __('Listo.') }}
            </x-action-message>
        </div>

        <!-- Modal de confirmación -->
        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                {{ __('Cerrar sesión en otros dispositivos') }}
            </x-slot>

            <x-slot name="content">
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ __('Ingresa tu contraseña para confirmar que deseas cerrar sesión en los demás navegadores y dispositivos donde tu cuenta esté activa.') }}
                </p>

                <div class="mt-4"
                     x-data="{}"
                     x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">

                    <x-input type="password"
                             class="mt-1 block w-3/4 rounded-xl"
                             autocomplete="current-password"
                             placeholder="{{ __('Contraseña') }}"
                             x-ref="password"
                             wire:model="password"
                             wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled" class="rounded-xl">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-button class="ms-3 rounded-xl"
                          wire:click="logoutOtherBrowserSessions"
                          wire:loading.attr="disabled">
                    {{ __('Confirmar cierre') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>