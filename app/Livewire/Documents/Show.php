<?php
namespace App\Livewire\Documents;

use App\Models\Document;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Show extends Component
{
    public Document $document;
    public $rejection_reason = '';

    public function mount(Document $document)
    {
        // Authorization check
        if (!Auth::user()->hasRole('Administrador') && $document->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este documento.');
        }

        $this->document = $document->load(['authors', 'career', 'location', 'user']);
    }

    public function downloadPdf()
    {
        if (!$this->document->pdf_path) {
            session()->flash('error', 'El archivo PDF no está disponible.');
            return;
        }

        // Return the file for download. Assume it's stored in 'private/documentos' disk.
        return Storage::disk('local')->download($this->document->pdf_path, $this->document->title . '.pdf');
    }

    public function changeStatus($status)
    {
        if (!Auth::user()->hasRole('Administrador')) {
            session()->flash('error', 'No tienes permiso para cambiar el estado de los documentos.');
            return;
        }

        if (!in_array($status, ['Pendiente', 'Aprobado'])) {
            return;
        }

        $this->document->update([
            'status' => $status,
            'rejection_reason' => null
        ]);
        $this->rejection_reason = '';
        session()->flash('message', "El documento ha sido marcado como {$status}.");
    }

    public function rejectDocument()
    {
        $this->validate([
            'rejection_reason' => 'required|string|min:10|max:1000'
        ], [
            'rejection_reason.required' => 'Debe indicar un motivo de rechazo.',
            'rejection_reason.min' => 'El motivo debe tener al menos 10 caracteres.'
        ]);

        if (!Auth::user()->hasRole('Administrador')) {
            return;
        }

        $this->document->update([
            'status' => 'Rechazado',
            'rejection_reason' => $this->rejection_reason
        ]);

        $this->dispatch('close-modal', 'reject-document-modal');
        session()->flash('message', "El documento ha sido rechazado exitosamente.");
    }

    public function render()
    {
        return view('livewire.documents.show', [
            'header' => 'Detalles del Documento'
        ]);
    }
}
