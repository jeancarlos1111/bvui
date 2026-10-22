<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white shadow-xl sm:rounded-lg">
        <div class="p-6 sm:p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Subir Documento Académico</h2>

            <form wire:submit="save" class="space-y-6">
                <!-- Título -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título de la Investigación</label>
                    <input type="text" wire:model="form.title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('form.title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Resumen -->
                <div>
                    <label for="abstract" class="block text-sm font-medium text-gray-700">Resumen (Abstracto)</label>
                    <textarea wire:model="form.abstract" id="abstract" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    @error('form.abstract') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Detalles (Año, Categoría) -->
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Año de Publicación</label>
                        <input type="number" wire:model="form.year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('form.year') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select wire:model="form.category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Seleccione una categoría</option>
                            <option value="TEG">Trabajo Especial de Grado (TEG)</option>
                            <option value="Pasantía">Pasantía</option>
                            <option value="Proyecto">Proyecto</option>
                            <option value="Servicio Comunitario">Servicio Comunitario</option>
                        </select>
                        @error('form.category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Ubicación y Carrera -->
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="career_id" class="block text-sm font-medium text-gray-700">Programa de Formación / Carrera</label>
                        <select wire:model.live="form.career_id" id="career_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" x-on:change="$event.target.value === 'new' ? $dispatch('open-modal', 'new-career-modal') : ''">
                            <option value="">Seleccione...</option>
                            @foreach($careers as $career)
                                <option value="{{ $career->id }}">{{ $career->name }}</option>
                            @endforeach
                            <option value="new" class="font-semibold text-indigo-600">+ Registrar nueva carrera</option>
                        </select>
                        @error('form.career_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <x-modal name="new-career-modal" focusable>
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900">Registrar Nueva Carrera</h2>
                                <div class="mt-4">
                                    <label for="new_career_name" class="block text-sm font-medium text-gray-700">Nombre de la Nueva Carrera</label>
                                    <input type="text" wire:model="form.new_career_name" id="new_career_name" placeholder="Ej. Licenciatura en Informática" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" wire:keydown.enter.prevent="saveNewCareer">
                                    @error('form.new_career_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button type="button" x-on:click="$dispatch('close'); $wire.set('form.career_id', '')" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancelar
                                    </button>
                                    <button type="button" wire:click="saveNewCareer" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Guardar Carrera
                                    </button>
                                </div>
                            </div>
                        </x-modal>
                    </div>

                    <div>
                        <label for="location_id" class="block text-sm font-medium text-gray-700">Sede / Núcleo</label>
                        <select wire:model.live="form.location_id" id="location_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" x-on:change="$event.target.value === 'new' ? $dispatch('open-modal', 'new-location-modal') : ''">
                            <option value="">Seleccione...</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                            <option value="new" class="font-semibold text-indigo-600">+ Registrar nueva sede / núcleo</option>
                        </select>
                        @error('form.location_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <x-modal name="new-location-modal" focusable>
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900">Registrar Nueva Sede / Núcleo</h2>
                                <div class="mt-4">
                                    <label for="new_location_name" class="block text-sm font-medium text-gray-700">Nombre de la Nueva Sede</label>
                                    <input type="text" wire:model="form.new_location_name" id="new_location_name" placeholder="Ej. Sede Los Chaguaramos" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" wire:keydown.enter.prevent="saveNewLocation">
                                    @error('form.new_location_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button type="button" x-on:click="$dispatch('close'); $wire.set('form.location_id', '')" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancelar
                                    </button>
                                    <button type="button" wire:click="saveNewLocation" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Guardar Sede
                                    </button>
                                </div>
                            </div>
                        </x-modal>
                    </div>
                </div>

                <!-- Archivo PDF -->
                <div x-data="{ uploading: false, progress: 0 }"
                     x-on:livewire-upload-start="uploading = true"
                     x-on:livewire-upload-finish="uploading = false"
                     x-on:livewire-upload-error="uploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <label class="block text-sm font-medium text-gray-700">Documento PDF</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                         x-bind:class="{ 'opacity-50 pointer-events-none': uploading }">
                        <div class="space-y-1 text-center w-full">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="pdf_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Seleccionar PDF</span>
                                    <input id="pdf_file" wire:model="form.pdf_file" name="pdf_file" type="file" accept="application/pdf" class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">Solo formato PDF hasta 20MB</p>

                            <!-- Progress Bar -->
                            <div x-show="uploading" class="mt-4 w-full max-w-xs mx-auto" style="display: none;">
                                <div class="flex items-center justify-between text-xs text-indigo-600 mb-1 font-semibold">
                                    <span>Subiendo archivo...</span>
                                    <span x-text="progress + '%'"></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" x-bind:style="'width: ' + progress + '%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('form.pdf_file') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    @if($form->pdf_file && empty($errors->get('form.pdf_file')))
                        <div class="text-sm text-green-600 mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Archivo seleccionado: {{ $form->pdf_file->getClientOriginalName() }}
                        </div>
                    @endif
                </div>

                <!-- Autores y Tutores -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Autores y Tutores</h3>
                        <button type="button" wire:click="addAuthor" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            + Agregar
                        </button>
                    </div>

                    @error('form.authors') <span class="text-red-500 text-xs block mb-2">{{ $message }}</span> @enderror

                    <div class="space-y-4">
                        @foreach($form->authors as $index => $author)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nombre Completo</label>
                                    <input type="text" wire:model="form.authors.{{ $index }}.name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="w-1/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Rol</label>
                                    <select wire:model="form.authors.{{ $index }}.type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Autor">Autor</option>
                                        <option value="Tutor Académico">Tutor Académico</option>
                                        <option value="Tutor Institucional">Tutor Institucional</option>
                                    </select>
                                </div>
                                <div class="pt-5">
                                    <button type="button" wire:click="removeAuthor({{ $index }})" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                            @error('form.authors.'.$index) <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                        @endforeach
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span wire:loading.remove wire:target="save">Subir Documento</span>
                        <span wire:loading wire:target="save">Procesando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
