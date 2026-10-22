<?php
namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Document;
use Livewire\Attributes\Layout;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Export;

#[Layout('layouts.app')]
class Index extends Component
{
    public $startDate;
    public $endDate;

    public $stats = [];

    public function mount()
    {
        $minDate = Document::min('created_at');
        $this->startDate = $minDate ? \Carbon\Carbon::parse($minDate)->format('Y-m-d') : now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->updateStats();
    }

    public function updatedStartDate() { $this->updateStats(); }
    public function updatedEndDate() { $this->updateStats(); }

    public function updateStats()
    {
        $query = Document::query()
            ->when($this->startDate, fn($q) => $q->whereDate('documents.created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('documents.created_at', '<=', $this->endDate));

        $this->stats = [
            'byCategory' => (clone $query)
                ->select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->pluck('total', 'category')
                ->toArray(),
            'byStatus' => (clone $query)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray(),
            'byCareer' => (clone $query)
                ->join('careers', 'documents.career_id', '=', 'careers.id')
                ->select('careers.name', DB::raw('count(*) as total'))
                ->groupBy('careers.name')
                ->pluck('total', 'name')
                ->toArray(),
            'byLocation' => (clone $query)
                ->join('locations', 'documents.location_id', '=', 'locations.id')
                ->select('locations.name', DB::raw('count(*) as total'))
                ->groupBy('locations.name')
                ->pluck('total', 'name')
                ->toArray(),
        ];
    }

    public function exportExcel()
    {
        $export = Export::create([
            'user_id' => auth()->id(),
            'type' => 'Excel',
        ]);

        \App\Jobs\GenerateExcelReport::dispatch($export->id, $this->startDate, $this->endDate);
        session()->flash('message', 'Exportación a Excel encolada.');
    }

    public function exportPdf()
    {
        $export = Export::create([
            'user_id' => auth()->id(),
            'type' => 'PDF',
        ]);

        \App\Jobs\GeneratePdfReport::dispatch($export->id, $this->startDate, $this->endDate);
        session()->flash('message', 'Exportación a PDF encolada.');
    }

    public function render()
    {
        $myExports = Export::where('user_id', auth()->id())->latest()->take(5)->get();
        
        return view('livewire.reports.index', [
            'exports' => $myExports,
        ]);
    }
}
