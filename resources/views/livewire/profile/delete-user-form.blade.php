<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header class="border-b border-gray-100 pb-5 mb-8">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight text-red-600">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>

    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium tracking-wide text-red-600 transition-all duration-200 bg-red-50 rounded-xl hover:bg-red-100 hover:text-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        {{ __('Eliminar Cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-8">

            <h2 class="text-xl font-semibold text-gray-900">
                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Por favor ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
            </p>

            <div class="mt-8 relative">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-5">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-200">
                    {{ __('Cancelar') }}
                </button>

                <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium tracking-wide text-white transition-all duration-200 bg-red-600 rounded-xl hover:bg-red-500 hover:shadow-lg hover:shadow-red-500/30 focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
