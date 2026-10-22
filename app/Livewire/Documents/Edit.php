<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Document;
use App\Models\Career;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class Edit extends Component
{
    use WithFileUploads;

    public Document $document;

    public $title;
    public $abstract;
    public $year;
    public $category;
    public $career_id;
    public $location_id;
    public $new_career_name = '';
    public $new_location_name = '';
    public $pdf_file;
    public $authors = [];

    public function mount(Document $document)
    {
        // Permission check
        if (!auth()->user()->hasRole('Administrador') && $document->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este documento.');
        }

        $this->document = $document;
        $this->title = $document->title;
        $this->abstract = $document->abstract;
        $this->year = $document->year;
        $this->category = $document->category;
        $this->career_id = $document->career_id;
        $this->location_id = $document->location_id;
        
        foreach ($document->authors as $author) {
            $this->authors[] = [
                'id' => $author->id,
                'name' => $author->name,
                'type' => $author->type,
            ];
        }

        if (empty($this->authors)) {
            $this->addAuthor();
        }
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'year' => 'required|integer|min:1950|max:2099',
            'category' => 'required|in:TEG,Pasantía,Proyecto,Servicio Comunitario',
            'career_id' => ['required', function ($attribute, $value, $fail) {
                if ($value !== 'new' && !\App\Models\Career::where('id', $value)->exists()) {
                    $fail('El programa de formación / carrera seleccionado es inválido.');
                }
            }],
            'new_career_name' => 'required_if:career_id,new|max:255|unique:careers,name',
            
            'location_id' => ['required', function ($attribute, $value, $fail) {
                if ($value !== 'new' && !\App\Models\Location::where('id', $value)->exists()) {
                    $fail('La sede / núcleo seleccionado es inválido.');
                }
            }],
            'new_location_name' => 'required_if:location_id,new|max:255|unique:locations,name',
            'pdf_file' => 'nullable|file|mimes:pdf|max:20480', // 20MB Max
        ];
    }

    public function saveNewCareer()
    {
        $this->validate([
            'new_career_name' => 'required|max:255|unique:careers,name',
        ]);

        $career = \App\Models\Career::create(['name' => $this->new_career_name]);
        $this->career_id = $career->id;
        $this->new_career_name = '';

        $this->dispatch('close-modal', 'new-career-modal');
    }

    public function saveNewLocation()
    {
        $this->validate([
            'new_location_name' => 'required|max:255|unique:locations,name',
        ]);

        $location = \App\Models\Location::create(['name' => $this->new_location_name]);
        $this->location_id = $location->id;
        $this->new_location_name = '';

        $this->dispatch('close-modal', 'new-location-modal');
    }

    public function addAuthor()
    {
        $this->authors[] = ['id' => null, 'name' => '', 'type' => 'Autor'];
    }

    public function removeAuthor($index)
    {
        unset($this->authors[$index]);
        $this->authors = array_values($this->authors);
    }

    public function save()
    {
        $this->validate();

        if (empty($this->authors) || empty($this->authors[0]['name'])) {
            throw ValidationException::withMessages([
                'authors' => 'Debe especificar al menos un autor válido.',
            ]);
        }

        foreach ($this->authors as $index => $author) {
            if (empty($author['name']) || empty($author['type'])) {
                throw ValidationException::withMessages([
                    "authors.{$index}" => 'Nombre y tipo son obligatorios para todos los autores.',
                ]);
            }
        }

        $careerIdToSave = $this->career_id;
        if ($this->career_id === 'new') {
            $career = \App\Models\Career::create(['name' => $this->new_career_name]);
            $careerIdToSave = $career->id;
        }

        $locationIdToSave = $this->location_id;
        if ($this->location_id === 'new') {
            $location = \App\Models\Location::create(['name' => $this->new_location_name]);
            $locationIdToSave = $location->id;
        }

        $this->document->update([
            'title' => $this->title,
            'abstract' => $this->abstract,
            'year' => $this->year,
            'category' => $this->category,
            'career_id' => $careerIdToSave,
            'location_id' => $locationIdToSave,
        ]);

        if ($this->pdf_file) {
            $path = $this->pdf_file->store('private/documentos');
            $this->document->update(['pdf_path' => $path]);
        }

        // Sync authors
        $this->document->authors()->delete();
        foreach ($this->authors as $authorData) {
            $this->document->authors()->create([
                'name' => $authorData['name'],
                'type' => $authorData['type'],
            ]);
        }

        session()->flash('message', 'Documento actualizado exitosamente.');

        return $this->redirect(route('documents.index'));
    }

    public function render()
    {
        return view('livewire.documents.edit', [
            'careers' => Career::all(),
            'locations' => Location::all(),
        ])->layout('layouts.app');
    }
}
