<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Export;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GeneratePdfReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;

    protected $exportId;
    protected $startDate;
    protected $endDate;

    public function __construct($exportId, $startDate, $endDate)
    {
        $this->exportId = $exportId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function handle(): void
    {
        ini_set('memory_limit', '1024M'); // Permitir hasta 1GB para DomPDF

        $export = Export::find($this->exportId);
        if (!$export) return;

        try {
            $documents = Document::with(['career', 'location', 'user'])
                ->when($this->startDate, fn($q) => $q->whereDate('documents.created_at', '>=', $this->startDate))
                ->when($this->endDate, fn($q) => $q->whereDate('documents.created_at', '<=', $this->endDate))
                ->orderBy('created_at', 'desc')
                ->limit(500) // DomPDF no puede procesar tablas gigantes, 500 max
                ->get();

            $pdf = Pdf::loadView('reports.pdf', [
                'documents' => $documents, 
                'startDate' => $this->startDate, 
                'endDate' => $this->endDate
            ]);

            $fileName = 'reporte_' . Str::random(10) . '_' . time() . '.pdf';
            $filePath = 'exports/' . $fileName;

            Storage::disk('local')->put($filePath, $pdf->output());

            $export->update([
                'status' => 'ready',
                'file_path' => $filePath,
            ]);
        } catch (\Exception $e) {
            $export->update(['status' => 'failed']);
            throw $e;
        }
    }
}
