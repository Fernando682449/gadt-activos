<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Información del perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualiza tu información de perfil y tu correo electrónico.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Foto de perfil -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Input oculto -->
                <input type="file" id="photo" class="hidden"
                       wire:model.live="photo"
                       x-ref="photo"
                       x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL($refs.photo.files[0]);
                       " />

                <x-label for="photo" value="{{ __('Foto de perfil') }}" />

                <div class="mt-3 flex items-center gap-4">
                    <!-- Foto actual -->
                    <div x-show="! photoPreview" class="relative">
                        <img src="{{ $this->user->profile_photo_url }}"
                             alt="{{ $this->user->name }}"
                             class="rounded-2xl h-20 w-20 object-cover border border-gray-200 shadow-sm">
                        <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-[10px] px-2 py-0.5 rounded-full bg-white border border-gray-200 text-gray-600 shadow-sm">
                            {{ __('Actual') }}
                        </span>
                    </div>

                    <!-- Preview -->
                    <div x-show="photoPreview" style="display: none;" class="relative">
                        <span class="block rounded-2xl w-20 h-20 bg-cover bg-no-repeat bg-center border border-gray-200 shadow-sm"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                        <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-[10px] px-2 py-0.5 rounded-full bg-white border border-gray-200 text-gray-600 shadow-sm">
                            {{ __('Vista previa') }}
                        </span>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm text-gray-700 font-semibold">
                            {{ __('Tu foto') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ __('Formatos recomendados: JPG/PNG. Tamaño sugerido: 400x400.') }}
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <x-secondary-button class="rounded-xl" type="button" x-on:click.prevent="$refs.photo.click()">
                                {{ __('Seleccionar nueva foto') }}
                            </x-secondary-button>

                            @if ($this->user->profile_photo_path)
                                <x-secondary-button type="button" class="rounded-xl" wire:click="deleteProfilePhoto">
                                    {{ __('Quitar foto') }}
                                </x-secondary-button>
                            @endif
                        </div>
                    </div>
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Nombre -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nombre') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full rounded-xl"
                     wire:model="state.name" required autocomplete="name"
                     placeholder="Ej: Juan Pérez" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Correo electrónico') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full rounded-xl"
                     wire:model="state.email" required autocomplete="username"
                     placeholder="ejemplo@correo.com" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div class="mt-3 p-4 rounded-2xl border border-amber-200 bg-amber-50">
                    <p class="text-sm text-amber-900 font-semibold">
                        {{ __('Tu correo electrónico aún no está verificado.') }}
                    </p>

                    <button type="button"
                            class="mt-2 inline-flex items-center font-semibold text-sm text-amber-800 hover:text-amber-900 underline underline-offset-4"
                            wire:click.prevent="sendEmailVerification">
                        {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                    </button>

                    @if ($this->verificationLinkSent)
                        <p class="mt-2 text-sm font-semibold text-emerald-700">
                            {{ __('Se envió un nuevo enlace de verificación a tu correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3 text-emerald-700 font-semibold" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo" class="rounded-xl">
            {{ __('Guardar cambios') }}
        </x-button>
    </x-slot>
</x-form-section>