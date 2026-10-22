<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-[#1e6199] shadow-lg relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center h-full">
                <!-- Logo Shield -->
                <a href="{{ route('home') }}" class="self-start bg-white px-2 pb-2 pt-0 rounded-b-xl shadow-md hover:scale-105 transition-transform flex-shrink-0" wire:navigate>
                    <div class="h-16 w-12 border-2 border-t-0 border-[#1e6199] rounded-b-full flex items-center justify-center relative flex-col pb-1">
                        <div class="text-[0.4rem] text-[#1e6199] font-bold text-center leading-tight mt-1">U.B.V.</div>
                        <svg class="w-6 h-6 text-[#1e6199] mt-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 14.72l5-2.45v3.72z"/></svg>
                    </div>
                </a>
                
                <div class="leading-tight hidden lg:block text-white ml-4">
                    <div class="text-xl font-bold uppercase tracking-wide">Biblioteca Virtual</div>
                    <div class="text-xl font-light uppercase tracking-wide">Universitaria</div>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:-my-px sm:ml-8 sm:flex sm:h-full items-center space-x-6">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                        {{ __('Inicio') }}
                    </x-nav-link>
                    
                    @auth
                    @if(auth()->user()->hasAnyRole(['Administrador', 'Gestor']))
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @endif

                    <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.index') || request()->routeIs('documents.*')" wire:navigate>
                        {{ __('Gestión de Documentos') }}
                    </x-nav-link>

                    @if(auth()->user()->hasAnyRole(['Administrador', 'Gestor']))
                    <x-nav-link :href="route('users')" :active="request()->routeIs('users') || request()->routeIs('users.*')" wire:navigate>
                        {{ __('Gestión de Usuarios') }}
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" wire:navigate>
                        {{ __('Reportes') }}
                    </x-nav-link>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 h-full">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-[#1e6199] bg-white hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150 shadow-sm group">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ml-2 transition-transform group-hover:translate-y-0.5">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate class="flex items-center text-gray-700 hover:text-[#1e6199]">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="flex items-center text-red-600 hover:text-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
                @else
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="text-white hover:text-white/80 font-semibold transition-colors flex items-center" wire:navigate>Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="bg-white text-[#1e6199] hover:bg-gray-100 px-5 py-2 rounded-xl font-semibold shadow-sm transition-colors flex items-center" wire:navigate>Registrarse</a>
                </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden h-full">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden absolute w-full bg-[#164a75] shadow-lg z-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                {{ __('Inicio') }}
            </x-responsive-nav-link>

            @auth
            @if(auth()->user()->hasAnyRole(['Administrador', 'Gestor']))
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.index') || request()->routeIs('documents.*')" wire:navigate>
                {{ __('Gestión de Documentos') }}
            </x-responsive-nav-link>

            @if(auth()->user()->hasAnyRole(['Administrador', 'Gestor']))
            <x-responsive-nav-link :href="route('users')" :active="request()->routeIs('users') || request()->routeIs('users.*')" wire:navigate>
                {{ __('Gestión de Usuarios') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" wire:navigate>
                {{ __('Reportes') }}
            </x-responsive-nav-link>
            @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            @auth
            <div class="px-4 mb-3">
                <div class="font-medium text-base text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-blue-200">{{ auth()->user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </button>
            </div>
            @else
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('login')" wire:navigate>
                    {{ __('Iniciar Sesión') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" wire:navigate>
                    {{ __('Registrarse') }}
                </x-responsive-nav-link>
            </div>
            @endauth
        </div>
    </div>
</nav>
