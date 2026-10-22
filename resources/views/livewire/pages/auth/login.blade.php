<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (auth()->user()->hasRole('Estudiante')) {
            $this->redirectIntended(default: route('home', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Bienvenido de nuevo</h2>
        <p class="mt-2 text-sm text-gray-500">Ingresa tus credenciales para acceder al sistema</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email or Cedula -->
        <div>
            <label for="login" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Correo Electrónico o Cédula') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input wire:model="form.login" id="login" type="text" name="login" required autofocus autocomplete="username" class="block w-full pl-10 py-2.5 rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] focus:bg-white text-sm transition-all duration-200" placeholder="tu@correo.com o V-12345678" />
            </div>
            <x-input-error :messages="$errors->get('form.login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Contraseña') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e6199] transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-10 py-2.5 rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:ring-2 focus:ring-[#1e6199]/20 focus:border-[#1e6199] focus:bg-white text-sm transition-all duration-200" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center cursor-pointer group">
                <div class="relative flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="peer h-4 w-4 rounded border-gray-300 text-[#1e6199] shadow-sm focus:ring-[#1e6199] transition-all cursor-pointer" name="remember">
                </div>
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#1e6199] hover:text-blue-800 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center items-center px-5 py-3 text-sm font-medium tracking-wide text-white transition-all duration-200 bg-gradient-to-r from-[#1e6199] to-blue-700 rounded-xl hover:shadow-lg hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199]">
                <span wire:loading.remove wire:target="login">{{ __('Iniciar Sesión') }}</span>
                <span wire:loading wire:target="login" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Ingresando...
                </span>
            </button>
        </div>
    </form>
</div>
