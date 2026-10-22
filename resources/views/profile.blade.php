<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight leading-tight">
                    {{ __('Mi Perfil') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Configuración avanzada y seguridad de la cuenta.</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199] transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Sidebar / Overview -->
                <div class="w-full lg:w-1/3 space-y-8">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative group transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50">
                        <div class="h-32 bg-gradient-to-br from-[#1e6199] to-blue-700 relative overflow-hidden">
                            <!-- Background decoration -->
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500"></div>
                            <div class="absolute -left-8 -bottom-8 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
                        </div>
                        <div class="px-8 pb-8 text-center relative -mt-16">
                            <div class="w-32 h-32 mx-auto bg-white rounded-full p-2 shadow-lg mb-4 relative transition-transform duration-300 group-hover:scale-105">
                                <div class="w-full h-full bg-gradient-to-br from-blue-50 to-gray-100 rounded-full flex items-center justify-center text-4xl font-bold text-[#1e6199]">
                                    <span x-data="{{ json_encode(['name' => substr(auth()->user()->name, 0, 1)]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name.substring(0, 1)"></span>
                                </div>
                                <div class="absolute bottom-2 right-2 w-5 h-5 bg-green-500 border-4 border-white rounded-full"></div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></h3>
                            <p class="text-sm text-gray-500 mb-4">{{ auth()->user()->email }}</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100/50">
                                {{ auth()->user()->roles->first()?->name ?? 'Usuario' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Forms Container -->
                <div class="w-full lg:w-2/3 space-y-8">
                    
                    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1e6199] to-blue-500"></div>
                        <div class="p-8 sm:p-10">
                            <livewire:profile.update-profile-information-form />
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-gray-700 to-gray-900"></div>
                        <div class="p-8 sm:p-10">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
                        <div class="p-8 sm:p-10">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
