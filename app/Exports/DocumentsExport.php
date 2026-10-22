<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocumentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Document::with(['career', 'location', 'user'])
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Categoría',
            'Estado',
            'Carrera',
            'Sede',
            'Fecha de Carga',
        ];
    }

    public function map($document): array
    {
        return [
            $document->id,
            $document->title,
            $document->category,
            $document->status,
            $document->career ? $document->career->name : 'N/A',
            $document->location ? $document->location->name : 'N/A',
            $document->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
