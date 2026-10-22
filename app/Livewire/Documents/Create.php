<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Career;
use App\Models\Location;
use App\Livewire\Forms\DocumentUploadForm;

class Create extends Component
{
    use WithFileUploads;

    public DocumentUploadForm $form;

    public function saveNewCareer()
    {
        $this->validate([
            'form.new_career_name' => 'required|max:255|unique:careers,name',
        ]);

        $career = \App\Models\Career::create(['name' => $this->form->new_career_name]);
        $this->form->career_id = $career->id;
        $this->form->new_career_name = '';

        $this->dispatch('close-modal', 'new-career-modal');
    }

    public function saveNewLocation()
    {
        $this->validate([
            'form.new_location_name' => 'required|max:255|unique:locations,name',
        ]);

        $location = \App\Models\Location::create(['name' => $this->form->new_location_name]);
        $this->form->location_id = $location->id;
        $this->form->new_location_name = '';

        $this->dispatch('close-modal', 'new-location-modal');
    }

    public function addAuthor()
    {
        $this->form->addAuthor();
    }

    public function removeAuthor($index)
    {
        $this->form->removeAuthor($index);
    }

    public function save()
    {
        $this->form->store();

        session()->flash('message', 'Documento subido exitosamente. Esperando revisión.');

        return $this->redirect(route('documents.index'));
    }

    public function render()
    {
        return view('livewire.documents.create', [
            'careers' => Career::all(),
            'locations' => Location::all(),
        ])->layout('layouts.app');
    }
}
