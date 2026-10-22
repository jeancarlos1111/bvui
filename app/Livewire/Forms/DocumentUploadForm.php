<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DocumentUploadForm extends Form
{
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string')]
    public $abstract = '';

    #[Validate('required|integer|min:1950|max:2099')]
    public $year;

    #[Validate('required|in:TEG,Pasantía,Proyecto,Servicio Comunitario')]
    public $category = '';

    public $career_id = '';
    public $new_career_name = '';

    public $location_id = '';
    public $new_location_name = '';

    public function rules()
    {
        return [
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
        ];
    }

    #[Validate('required|file|mimes:pdf|max:20480')] // 20MB Max
    public $pdf_file;

    // List of authors/tutors
    public $authors = [
        ['name' => '', 'type' => 'Autor']
    ];

    public function addAuthor()
    {
        $this->authors[] = ['name' => '', 'type' => 'Autor'];
    }

    public function removeAuthor($index)
    {
        unset($this->authors[$index]);
        $this->authors = array_values($this->authors);
    }

    public function store()
    {
        $this->validate();

        // Custom validation for at least one author
        if (empty($this->authors) || empty($this->authors[0]['name'])) {
            throw ValidationException::withMessages([
                'form.authors' => 'Debe especificar al menos un autor válido.',
            ]);
        }

        // Validate each author
        foreach ($this->authors as $index => $author) {
            if (empty($author['name']) || empty($author['type'])) {
                throw ValidationException::withMessages([
                    "form.authors.{$index}" => 'Nombre y tipo son obligatorios para todos los autores.',
                ]);
            }
        }

        $path = $this->pdf_file->store('private/documentos');

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

        $document = Document::create([
            'title' => $this->title,
            'abstract' => $this->abstract,
            'year' => $this->year,
            'category' => $this->category,
            'career_id' => $careerIdToSave,
            'location_id' => $locationIdToSave,
            'user_id' => auth()->id(),
            'pdf_path' => $path,
            'status' => 'Pendiente',
        ]);

        foreach ($this->authors as $authorData) {
            $document->authors()->create($authorData);
        }

        $this->reset();
    }
}
