<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Document;
use App\Models\Career;
use App\Models\Location;

class DocumentSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategories = [];
    public $selectedCareers = [];
    public $selectedYears = [];
    public $selectedLocations = [];

    // Reset pagination when filters change
    public function updatedSearch() { $this->resetPage(); }
    public function updatedSelectedCategories() { $this->resetPage(); }
    public function updatedSelectedCareers() { $this->resetPage(); }
    public function updatedSelectedYears() { $this->resetPage(); }
    public function updatedSelectedLocations() { $this->resetPage(); }

    public function toggleCategory($category)
    {
        if (in_array($category, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$category]);
        } else {
            $this->selectedCategories[] = $category;
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = Document::search($this->search)
            ->where('status', 'Aprobado'); // Only show approved documents

        if (!empty($this->selectedCategories)) {
            $query->whereIn('category', $this->selectedCategories);
        }
        
        if (!empty($this->selectedCareers)) {
            $query->whereIn('career_id', $this->selectedCareers);
        }

        if (!empty($this->selectedLocations)) {
            $query->whereIn('location_id', $this->selectedLocations);
        }

        if (!empty($this->selectedYears)) {
            $query->whereIn('year', $this->selectedYears);
        }

        $documents = $query->orderBy('created_at', 'desc')
            ->query(fn ($q) => $q->with(['authors', 'career', 'location']))
            ->paginate(12);
        
        // Fetch distinct years from approved documents for the filter
        $availableYears = Document::where('status', 'Aprobado')->select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('livewire.document-search', [
            'documents' => $documents,
            'careers' => Career::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
            'availableYears' => $availableYears,
        ])->layout('layouts.app');
    }
}
