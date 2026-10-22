<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight leading-tight">
                    {{ __('Detalles del Usuario') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Visualiza la información completa de esta cuenta.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('users.edit', $user->id) }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-[#1e6199] to-blue-700 rounded-lg shadow-sm hover:shadow-lg hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199] transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Editar
                </a>
                <a href="{{ route('users') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e6199] transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50">
                
                <!-- Encabezado de la Tarjeta (Perfil) -->
                <div class="relative h-32 bg-gradient-to-r from-[#1e6199] to-blue-600">
                    <div class="absolute -bottom-12 left-8">
                        <div class="h-24 w-24 rounded-2xl bg-white p-1.5 shadow-lg border border-gray-100 flex-shrink-0">
                            <div class="h-full w-full rounded-xl bg-gradient-to-br from-blue-50 to-gray-100 flex items-center justify-center text-[#1e6199] text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-16 pb-8 px-8 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-500 font-medium mt-1">{{ $user->email }}</p>
                        </div>
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-blue-50 text-blue-700 border border-blue-100/50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.957 11.957 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            {{ $user->roles->first()?->name ?? 'Sin Rol' }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Información Detallada</h3>
                    
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-8">
                        <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                Cédula de Identidad
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $user->cedula ?? 'No especificada' }}</dd>
                        </div>
                        
                        <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Fecha de Registro
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $user->created_at->format('d de M Y, h:i A') }}</dd>
                        </div>

                        <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Estado de la Cuenta
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900 flex items-center">
                                @if(!$user->trashed())
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Activo
                                @else
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Desactivado ({{ $user->deleted_at->format('d M Y') }})
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>
