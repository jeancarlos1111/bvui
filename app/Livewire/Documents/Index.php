<?php
namespace App\Livewire\Documents;

use App\Models\Document;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Layout;

use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    public $query;
    public $documentToDelete = null;
    
    public function confirmDocumentDeletion($id)
    {
        $this->documentToDelete = $id;
    }

    public function cancelDocumentDeletion()
    {
        $this->documentToDelete = null;
    }
    
    public function deleteDocument()
    {
        if (!$this->documentToDelete) return;

        $document = Document::findOrFail($this->documentToDelete);
        
        // Authorization check: Admin can delete any, user can only delete their own
        if (!Auth::user()->hasRole('Administrador') && $document->user_id !== Auth::id()) {
            session()->flash('error', 'No tienes permiso para eliminar este documento.');
            $this->documentToDelete = null;
            return;
        }

        $document->delete();
        $this->documentToDelete = null;
        session()->flash('message', 'Documento eliminado exitosamente.');
    }



    public function render()
    {
        $searchQuery = $this->query ?: '';
        $queryBuilder = Document::search($searchQuery);

        // Filtrado por visibilidad: Admin ve todos, usuario ve los suyos
        if (!Auth::user()->hasRole('Administrador')) {
            $queryBuilder->where('user_id', Auth::id());
        }

        $documents = $queryBuilder->orderBy('created_at', 'desc')
            ->query(fn ($q) => $q->with(['career', 'location', 'user']))
            ->paginate(10);

        return view('livewire.documents.index', compact('documents'));
    }
}
