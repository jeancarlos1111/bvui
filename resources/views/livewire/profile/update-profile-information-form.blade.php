<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $cedula = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->cedula = Auth::user()->cedula ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'cedula' => ['required', 'string', 'max:20', 'regex:/^[VE]-\d+$/', Rule::unique(User::class)->ignore($user->id)],
        ], [
            'cedula.regex' => 'La cédula debe comenzar con V- o E- seguido de números (Ej. V-12345678).',
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="border-b border-gray-100 pb-5 mb-8">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            {{ __("Actualiza la información del perfil y la dirección de correo electrónico de tu cuenta.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <div class="space-y-2 group">
                <x-input-label for="name" value="{{ __('Nombre Completo') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <x-text-input wire:model="name" id="name" name="name" type="text" class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] transition-all duration-200" required autofocus autocomplete="name" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2 group">
                <x-input-label for="cedula" value="{{ __('Cédula de Identidad') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </div>
                    <x-text-input wire:model="cedula" id="cedula" name="cedula" type="text" class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] transition-all duration-200" required />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('cedula')" />
            </div>
        </div>

        <div class="space-y-2 group">
            <x-input-label for="email" value="{{ __('Correo Electrónico') }}" class="text-sm font-semibold text-gray-700 group-focus-within:text-[#1e6199] transition-colors" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full pl-10 py-2.5 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] transition-all duration-200" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Tu dirección de correo no está verificada.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-[#1e6199] hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199]">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
            <x-action-message class="me-3 text-sm font-medium text-green-600 bg-green-50 px-3 py-1.5 rounded-lg" on="profile-updated">
                {{ __('Guardado exitosamente.') }}
            </x-action-message>
            
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium tracking-wide text-white transition-all duration-200 bg-gradient-to-r from-[#1e6199] to-blue-700 rounded-xl hover:shadow-lg hover:shadow-blue-500/30 focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199]">
                <svg wire:loading.remove wire:target="updateProfileInformation" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <svg wire:loading wire:target="updateProfileInformation" class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                {{ __('Guardar Cambios') }}
            </button>
        </div>
    </form>
</section>
