<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Export;
use App\Exports\DocumentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class GenerateExcelReport implements ShouldQueue
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
        $export = Export::find($this->exportId);
        if (!$export) return;

        try {
            $fileName = 'reporte_' . Str::random(10) . '_' . time() . '.xlsx';
            $filePath = 'exports/' . $fileName;

            Excel::store(new DocumentsExport($this->startDate, $this->endDate), $filePath, 'local');

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
