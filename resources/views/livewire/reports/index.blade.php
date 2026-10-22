<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-[#1e6199]">Reportes y Estadísticas</h2>
                    <div class="flex space-x-3">
                        <button wire:click="exportExcel" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center disabled:opacity-50">
                            <svg wire:loading.remove wire:target="exportExcel" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <svg wire:loading wire:target="exportExcel" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="exportExcel">Exportar Excel</span>
                            <span wire:loading wire:target="exportExcel">Generando...</span>
                        </button>
                        <button wire:click="exportPdf" wire:loading.attr="disabled" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center disabled:opacity-50">
                            <svg wire:loading.remove wire:target="exportPdf" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <svg wire:loading wire:target="exportPdf" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="exportPdf">Exportar PDF</span>
                            <span wire:loading wire:target="exportPdf">Generando...</span>
                        </button>
                    </div>
                </div>

                <!-- Filtros de Fecha -->
                <div class="bg-gray-50 p-4 rounded-xl mb-8 flex items-end space-x-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" wire:model.live="startDate" class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" wire:model.live="endDate" class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="text-sm text-gray-500 pb-2">
                        Los gráficos se actualizan automáticamente al cambiar las fechas.
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Gráfico por Categoría -->
                    <div class="bg-white p-4 border rounded-xl shadow-sm"
                         x-data="{
                            chart: null,
                            initChart() {
                                if (!window.Chart) {
                                    setTimeout(() => this.initChart(), 50);
                                    return;
                                }
                                if (this.chart) this.chart.destroy();
                                const ctx = this.$refs.canvas.getContext('2d');
                                const stats = this.$wire.stats;
                                if (!stats || !stats.byCategory) return;
                                const data = JSON.parse(JSON.stringify(stats.byCategory));
                                this.chart = new window.Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: Object.keys(data),
                                        datasets: [{
                                            data: Object.values(data),
                                            backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6']
                                        }]
                                    },
                                    options: { responsive: true, plugins: { title: { display: true, text: 'Documentos por Categoría' } } }
                                });
                            }
                         }"
                         x-init="initChart(); $watch('$wire.stats.byCategory', () => initChart())">
                        <canvas x-ref="canvas" wire:ignore></canvas>
                    </div>

                    <!-- Gráfico por Estado -->
                    <div class="bg-white p-4 border rounded-xl shadow-sm"
                         x-data="{
                            chart: null,
                            initChart() {
                                if (!window.Chart) {
                                    setTimeout(() => this.initChart(), 50);
                                    return;
                                }
                                if (this.chart) this.chart.destroy();
                                const ctx = this.$refs.canvas.getContext('2d');
                                const stats = this.$wire.stats;
                                if (!stats || !stats.byStatus) return;
                                const data = JSON.parse(JSON.stringify(stats.byStatus));
                                this.chart = new window.Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: Object.keys(data),
                                        datasets: [{
                                            data: Object.values(data),
                                            backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
                                        }]
                                    },
                                    options: { responsive: true, plugins: { title: { display: true, text: 'Documentos por Estado' } } }
                                });
                            }
                         }"
                         x-init="initChart(); $watch('$wire.stats.byStatus', () => initChart())">
                        <canvas x-ref="canvas" wire:ignore></canvas>
                    </div>

                    <!-- Gráfico por Sede -->
                    <div class="bg-white p-4 border rounded-xl shadow-sm col-span-1 md:col-span-2"
                         x-data="{
                            chart: null,
                            initChart() {
                                if (!window.Chart) {
                                    setTimeout(() => this.initChart(), 50);
                                    return;
                                }
                                if (this.chart) this.chart.destroy();
                                const ctx = this.$refs.canvas.getContext('2d');
                                const stats = this.$wire.stats;
                                if (!stats || !stats.byLocation) return;
                                const data = JSON.parse(JSON.stringify(stats.byLocation));
                                this.chart = new window.Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: Object.keys(data),
                                        datasets: [{
                                            label: 'Documentos',
                                            data: Object.values(data),
                                            backgroundColor: '#1e6199'
                                        }]
                                    },
                                    options: { responsive: true, plugins: { title: { display: true, text: 'Documentos por Sede' } } }
                                });
                            }
                         }"
                         x-init="initChart(); $watch('$wire.stats.byLocation', () => initChart())">
                        <canvas x-ref="canvas" wire:ignore></canvas>
                    </div>
                </div>

                <!-- Historial de Reportes -->
                <div class="mt-8 bg-white p-6 border rounded-xl shadow-sm" wire:poll.5s>
                    <h3 class="text-xl font-bold text-[#1e6199] mb-4">Mis Reportes Generados</h3>
                    @if (session()->has('message'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Solicitud</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($exports as $export)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $export->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $export->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($export->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 animate-pulse">Generando...</span>
                                        @elseif($export->status === 'ready')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Listo</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Fallido</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($export->status === 'ready')
                                            <a href="{{ route('reports.download', $export->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Descargar
                                            </a>
                                        @else
                                            <span class="text-gray-400">No disponible</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No has generado reportes recientes.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
