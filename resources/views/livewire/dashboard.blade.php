<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
            </div>

            <!-- Main Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-md group">
                    <div class="p-3 bg-blue-50 text-[#1e6199] rounded-xl mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Documentos</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $metrics['total'] }}</p>
                </div>

                <!-- Aprobados -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-md group">
                    <div class="p-3 bg-green-50 text-green-600 rounded-xl mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Aprobados</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $metrics['approved'] }}</p>
                </div>

                <!-- Pendientes -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-md group">
                    <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pendientes</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $metrics['pending'] }}</p>
                </div>

                <!-- Rechazados -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-md group">
                    <div class="p-3 bg-red-50 text-red-600 rounded-xl mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Rechazados</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $metrics['rejected'] }}</p>
                </div>
            </div>

            <!-- Categories Metrics -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h4 class="text-lg font-semibold text-gray-900 mb-6">Distribución por Categoría</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($categories as $category => $count)
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ $category }}</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $count }}</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-white shadow-sm flex items-center justify-center text-[#1e6199]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
