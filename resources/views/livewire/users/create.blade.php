<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight leading-tight">
                    {{ __('Crear Usuario') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Agrega un nuevo miembro al sistema asignándole un rol específico.</p>
            </div>
            <div>
                <a href="{{ route('users') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199] transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver
                </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50">
                <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-800">Información del Usuario</h3>
                    <p class="text-sm text-gray-500 mt-1">Completa los datos requeridos para registrar la nueva cuenta.</p>
                </div>

                <div class="p-8">
                    <form wire:submit.prevent="save" class="space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Name -->
                            <div class="space-y-2 group">
                                <x-input-label for="name" value="{{ __('Nombre Completo') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <x-text-input wire:model="name" id="name" class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] transition-all duration-200" type="text" name="name" required autofocus placeholder="Ej. Juan Pérez" />
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>

                            <!-- Cedula -->
                            <div class="space-y-2 group">
                                <x-input-label for="cedula" value="{{ __('Cédula de Identidad') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    </div>
                                    <x-text-input wire:model="cedula" id="cedula" class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] transition-all duration-200" type="text" name="cedula" required placeholder="Ej. V-12345678" />
                                </div>
                                <x-input-error :messages="$errors->get('cedula')" class="mt-1" />
                            </div>

                            <!-- Email Address -->
                            <div class="space-y-2 group">
                                <x-input-label for="email" value="{{ __('Correo Electrónico') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <x-text-input wire:model="email" id="email" class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] transition-all duration-200" type="email" name="email" required placeholder="correo@ejemplo.com" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />
                            </div>

                            <!-- Password -->
                            <div class="space-y-2 group" x-data="{ show: false }">
                                <x-input-label for="password" value="{{ __('Contraseña') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <x-text-input wire:model="password" id="password" class="block w-full pl-10 pr-12 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] transition-all duration-200" x-bind:type="show ? 'text' : 'password'" name="password" required placeholder="Mínimo 8 caracteres" />
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#1e6199] focus:outline-none transition-colors">
                                        <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg x-show="show" x-cloak style="display: none;" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            </div>

                            <!-- Role -->
                            <div class="space-y-2 group">
                                <x-input-label for="role" value="{{ __('Rol de Sistema') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.957 11.957 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    </div>
                                    <select wire:model="role" id="role" class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] text-gray-700 transition-all duration-200" required>
                                        <option value="" disabled selected>Seleccione un rol...</option>
                                        @foreach($roles as $r)
                                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('role')" class="mt-1" />
                            </div>
                        </div>

                        <div class="pt-6 mt-8 border-t border-gray-100 flex items-center justify-end gap-4">
                            <a href="{{ route('users') }}" wire:navigate class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-transparent hover:bg-gray-100 rounded-xl transition-colors duration-200">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium tracking-wide text-white transition-all duration-200 bg-gradient-to-r from-[#1e6199] to-blue-700 rounded-xl hover:shadow-lg hover:shadow-blue-500/30 focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199]">
                                <svg wire:loading.remove wire:target="save" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <svg wire:loading wire:target="save" class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span wire:loading.remove wire:target="save">{{ __('Registrar Usuario') }}</span>
                                <span wire:loading wire:target="save">{{ __('Guardando...') }}</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
