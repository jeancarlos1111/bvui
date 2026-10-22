<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight leading-tight">
                    {{ $document->title }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Subido el {{ $document->created_at->format('d/m/Y') }} por {{ $document->user?->name }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('documents.index') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver
                </a>
                <button wire:click="downloadPdf" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium tracking-wide text-white transition-all duration-200 bg-gradient-to-r from-[#1e6199] to-blue-700 rounded-xl hover:shadow-lg hover:shadow-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Descargar PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Columna Izquierda (Metadatos) -->
                <div class="col-span-1 md:col-span-2 space-y-6">
                    <!-- Tarjeta Principal -->
                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Información General</h3>

                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Resumen</h4>
                                <p class="mt-1 text-sm text-gray-900 text-justify">{{ $document->abstract ?: 'Sin resumen disponible.' }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Categoría</h4>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $document->category }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Año</h4>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $document->year }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Programa de Formación / Carrera</h4>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $document->career?->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Sede / Núcleo</h4>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $document->location?->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Autores -->
                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Autores y Tutores</h3>
                        <ul class="divide-y divide-gray-100">
                            @foreach($document->authors as $author)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                                        {{ substr($author->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $author->name }} {{ $author->last_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $author->cedula }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $author->type }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Visor de PDF con PDF.js -->
                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6 flex flex-col" style="height: 1000px;" x-data="pdfViewer('{{ route('documents.pdf', $document->id) }}')">
                        <h3 class="text-sm font-medium text-gray-900 mb-4 flex items-center justify-between">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                                Visor de Documento
                            </span>
                            <button wire:click="downloadPdf" class="text-xs text-[#1e6199] hover:text-blue-800 font-medium flex items-center bg-blue-50 px-3 py-1.5 rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Descargar Original
                            </button>
                        </h3>

                        <!-- Controles de PDF.js -->
                        <div class="flex items-center justify-between mb-4 bg-gray-50 p-2 rounded-lg border border-gray-200">
                            <button @click="prevPage" :disabled="pageNum <= 1" class="px-3 py-1.5 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 disabled:opacity-50 hover:bg-gray-100 transition-colors">Anterior</button>
                            <span class="text-sm font-medium text-gray-700">Pág. <span x-text="pageNum"></span> de <span x-text="pageCount"></span></span>
                            <button @click="nextPage" :disabled="pageNum >= pageCount" class="px-3 py-1.5 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 disabled:opacity-50 hover:bg-gray-100 transition-colors">Siguiente</button>
                        </div>

                        <!-- Contenedor del Canvas -->
                        <div class="flex-1 overflow-auto bg-gray-100 rounded-xl border border-gray-200 flex justify-center items-start p-4 relative">
                            <div x-show="loading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-100/90 z-10 rounded-xl">
                                <svg class="w-8 h-8 text-[#1e6199] animate-spin mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span class="text-sm text-gray-700 font-medium animate-pulse">Cargando visualizador PDF...</span>
                            </div>
                            <canvas x-ref="pdfCanvas" class="shadow-lg bg-white max-w-full h-auto object-contain"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha (Estado y PDF) -->
                <div class="col-span-1 space-y-6">
                    <!-- Tarjeta de Estado -->
                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6 text-center">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Estado de Revisión</h3>

                        @if($document->status === 'Aprobado')
                            <div class="inline-flex flex-col items-center justify-center p-4 bg-green-50 rounded-xl border border-green-100 w-full">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                                <span class="text-lg font-bold text-green-700">Aprobado</span>
                                <span class="text-xs text-green-600 mt-1">Este documento está visible en la biblioteca.</span>
                            </div>
                        @elseif($document->status === 'Rechazado')
                            <div class="inline-flex flex-col items-center justify-center p-4 bg-red-50 rounded-xl border border-red-100 w-full">
                                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                <span class="text-lg font-bold text-red-700">Rechazado</span>
                                <span class="text-xs text-red-600 mt-1">El documento ha sido rechazado.</span>
                                @if($document->rejection_reason)
                                    <div class="mt-3 p-3 bg-red-100/50 rounded-lg text-sm text-red-800 text-left w-full border border-red-200">
                                        <span class="font-semibold block mb-1">Motivo:</span>
                                        {{ $document->rejection_reason }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="inline-flex flex-col items-center justify-center p-4 bg-yellow-50 rounded-xl border border-yellow-100 w-full">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-lg font-bold text-yellow-700">Pendiente de Revisión</span>
                                <span class="text-xs text-yellow-600 mt-1">El documento será evaluado por un administrador.</span>
                            </div>
                        @endif

                        @if(auth()->user()->hasRole('Administrador'))
                            <div class="mt-6 flex flex-col gap-3 pt-6 border-t border-gray-100">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Acciones de Administrador</p>
                                @if($document->status !== 'Aprobado')
                                    <button wire:click="changeStatus('Aprobado')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Aprobar Documento
                                    </button>
                                @endif

                                @if($document->status !== 'Rechazado')
                                    <button x-data x-on:click="$dispatch('open-modal', 'reject-document-modal')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Rechazar Documento
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>

                    <x-modal name="reject-document-modal" focusable>
                        <form wire:submit="rejectDocument" class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Rechazar Documento
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Por favor, indica el motivo por el cual este documento está siendo rechazado. Esta información será visible para el usuario que lo subió.
                            </p>

                            <div class="mt-6">
                                <label for="rejection_reason" class="sr-only">Motivo de Rechazo</label>
                                <textarea
                                    wire:model="rejection_reason"
                                    id="rejection_reason"
                                    rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                                    placeholder="Ej. El documento no cumple con el formato requerido..."
                                ></textarea>
                                @error('rejection_reason') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancelar
                                </button>

                                <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Confirmar Rechazo
                                </button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Component Initialization -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pdfViewer', (url) => {
                let _pdfDoc = null; // Almacenar el documento fuera de Alpine para evitar el Proxy Error

                return {
                    pageNum: 1,
                    pageCount: 0,
                    loading: true,
                    url: url,

                    init() {
                        const canvas = this.$refs.pdfCanvas;
                        const ctx = canvas.getContext('2d');

                        pdfjsLib.getDocument(this.url).promise.then(pdfDoc_ => {
                            _pdfDoc = pdfDoc_;
                            this.pageCount = _pdfDoc.numPages;
                            this.loading = false;
                            this.renderPage(this.pageNum, canvas, ctx);
                        }).catch(error => {
                            console.error('Error al cargar el PDF: ', error);
                            this.loading = false;
                        });
                    },

                    renderPage(num, canvas, ctx) {
                        if (!_pdfDoc) return;

                        _pdfDoc.getPage(num).then(page => {
                            // Escalar el PDF para que se ajuste al ancho del contenedor
                            const parentWidth = canvas.parentElement.clientWidth - 32;
                            const viewport = page.getViewport({ scale: 1 });
                            const scale = parentWidth / viewport.width;
                            const scaledViewport = page.getViewport({ scale: scale });

                            canvas.height = scaledViewport.height;
                            canvas.width = scaledViewport.width;

                            const renderContext = {
                                canvasContext: ctx,
                                viewport: scaledViewport
                            };

                            page.render(renderContext);
                        });
                    },

                    prevPage() {
                        if (this.pageNum <= 1) return;
                        this.pageNum--;
                        this.renderPage(this.pageNum, this.$refs.pdfCanvas, this.$refs.pdfCanvas.getContext('2d'));
                    },

                    nextPage() {
                        if (this.pageNum >= this.pageCount) return;
                        this.pageNum++;
                        this.renderPage(this.pageNum, this.$refs.pdfCanvas, this.$refs.pdfCanvas.getContext('2d'));
                    }
                };
            });
        });
    </script>
</div>
