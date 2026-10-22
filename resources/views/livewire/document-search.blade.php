<div class="bg-gray-50 font-sans pb-12">
    <!-- Hero / Search Section -->
    <div class="relative bg-blue-900 h-64 md:h-80 flex items-center justify-center">
        <div class="absolute inset-0">
            <!-- Library background -->
            <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Library" class="w-full h-full object-cover mix-blend-overlay opacity-40">
            <div class="absolute inset-0 bg-[#1e6199]/70 mix-blend-multiply"></div>
        </div>
        
        <div class="relative z-10 w-full max-w-4xl px-4">
            <div class="relative flex items-center">
                <input type="text" wire:model.live.debounce.500ms="search" class="w-full rounded-full border-0 py-4 pl-8 pr-16 text-gray-900 shadow-2xl focus:ring-4 focus:ring-[#1e6199] focus:outline-none text-lg placeholder:text-gray-500" placeholder="Busca en el repositorio de la universidad...">
                <div class="absolute right-4 text-gray-400">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Cards -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative -mt-24 md:-mt-20 z-20">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                <!-- TEG -->
                <button wire:click="toggleCategory('TEG')" class="flex flex-col items-center justify-center p-6 rounded-3xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl {{ in_array('TEG', $selectedCategories) ? 'ring-4 ring-offset-2 ring-[#3b82f6] scale-105' : '' }}" style="background-color: #3b82f6;">
                    <div class="bg-white p-4 rounded-full mb-4 shadow-sm">
                        <svg class="h-10 w-10 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <span class="text-white font-bold text-center text-sm md:text-base leading-tight uppercase">Trabajo<br>Especial de<br>Grado (TEG)</span>
                </button>

                <!-- PASANTÍAS -->
                <button wire:click="toggleCategory('Pasantía')" class="flex flex-col items-center justify-center p-6 rounded-3xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl {{ in_array('Pasantía', $selectedCategories) ? 'ring-4 ring-offset-2 ring-[#4ade80] scale-105' : '' }}" style="background-color: #4ade80;">
                    <div class="bg-white p-4 rounded-full mb-4 shadow-sm">
                        <svg class="h-10 w-10 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-white font-bold text-center text-sm md:text-base uppercase mt-5">Pasantías</span>
                </button>

                <!-- PROYECTO -->
                <button wire:click="toggleCategory('Proyecto')" class="flex flex-col items-center justify-center p-6 rounded-3xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl {{ in_array('Proyecto', $selectedCategories) ? 'ring-4 ring-offset-2 ring-[#fbbf24] scale-105' : '' }}" style="background-color: #facc15;">
                    <div class="bg-white p-4 rounded-full mb-4 shadow-sm">
                        <svg class="h-10 w-10 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <span class="text-white font-bold text-center text-sm md:text-base uppercase mt-5">Proyecto</span>
                </button>

                <!-- SERVICIO COMUNITARIO -->
                <button wire:click="toggleCategory('Servicio Comunitario')" class="flex flex-col items-center justify-center p-6 rounded-3xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl {{ in_array('Servicio Comunitario', $selectedCategories) ? 'ring-4 ring-offset-2 ring-[#ef4444] scale-105' : '' }}" style="background-color: #ef4444;">
                    <div class="bg-white p-4 rounded-full mb-4 shadow-sm">
                        <svg class="h-10 w-10 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-white font-bold text-center text-sm md:text-base leading-tight uppercase">Servicio<br>Comunitario</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar / Filters -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <!-- Carrera -->
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Filtrar por Carrera</h3>
                        <div class="space-y-2">
                            @foreach($careers as $career)
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model.live="selectedCareers" value="{{ $career->id }}" id="career_{{ $career->id }}" class="h-4 w-4 text-[#1e6199] focus:ring-[#1e6199] border-gray-300 rounded">
                                    <label for="career_{{ $career->id }}" class="ml-2 text-sm text-gray-700">{{ $career->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Año -->
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Año</h3>
                        <div class="space-y-2">
                            @foreach($availableYears as $year)
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model.live="selectedYears" value="{{ $year }}" id="year_{{ $year }}" class="h-4 w-4 text-[#1e6199] focus:ring-[#1e6199] border-gray-300 rounded">
                                    <label for="year_{{ $year }}" class="ml-2 text-sm text-gray-700">{{ $year }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sede -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Sede</h3>
                        <div class="space-y-2">
                            @foreach($locations as $location)
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model.live="selectedLocations" value="{{ $location->id }}" id="location_{{ $location->id }}" class="h-4 w-4 text-[#1e6199] focus:ring-[#1e6199] border-gray-300 rounded">
                                    <label for="location_{{ $location->id }}" class="ml-2 text-sm text-gray-700">{{ $location->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Grid -->
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Resultados Recientes / Destacados</h2>
                
                @if($documents->isEmpty())
                    <div class="bg-white p-8 rounded-xl border border-gray-200 text-center text-gray-500">
                        No se encontraron documentos que coincidan con los filtros seleccionados.
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($documents as $doc)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow p-4">
                                <div class="flex gap-4">
                                    <!-- Miniature document -->
                                    <div class="w-16 h-24 bg-white border shadow-sm border-gray-200 flex-shrink-0 flex flex-col items-center pt-2 relative">
                                        <div class="w-10 h-[2px] bg-gray-200 mb-1"></div>
                                        <div class="w-12 h-[2px] bg-gray-200 mb-1"></div>
                                        <div class="w-12 h-[2px] bg-gray-200 mb-1"></div>
                                        <div class="w-8 h-[2px] bg-gray-200 mb-4"></div>
                                        <div class="absolute bottom-0 w-full h-1 bg-[#1e6199]"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-gray-900 leading-tight mb-1 truncate">{{ $doc->title }}</h3>
                                        <p class="text-[11px] text-gray-600 mb-0.5">
                                            by <span class="font-medium">{{ $doc->authors->where('type', 'Autor')->pluck('name')->join(', ') ?: 'Autor Desconocido' }}</span>
                                        </p>
                                        <p class="text-[11px] text-gray-500 mb-2">{{ $doc->created_at->format('d M Y') }}</p>
                                        
                                        <div class="flex flex-wrap gap-1 mt-auto">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#1e6199] text-white uppercase tracking-wide">
                                                Tipoes
                                            </span>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wide
                                                @if($doc->category == 'TEG') bg-yellow-400 text-yellow-900
                                                @elseif($doc->category == 'Pasantía') bg-green-400 text-green-900
                                                @elseif($doc->category == 'Proyecto') bg-orange-400 text-orange-900
                                                @else bg-red-400 text-red-900 @endif">
                                                {{ $doc->category }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $documents->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
