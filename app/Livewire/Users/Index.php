<?php
namespace App\Livewire\Users;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Layout;

use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    public $query;
    public $userToDelete = null;
    
    public function confirmUserDeletion($id)
    {
        $this->userToDelete = $id;
    }

    public function cancelUserDeletion()
    {
        $this->userToDelete = null;
    }
    
    public function deleteUser()
    {
        if (!$this->userToDelete) return;

        $user = User::findOrFail($this->userToDelete);
        
        // Evitar eliminar al usuario autenticado por seguridad
        if ($user->id === Auth::id()) {
            session()->flash('message', 'No puedes eliminar tu propia cuenta.');
            $this->userToDelete = null;
            return;
        }

        $user->delete();
        $this->userToDelete = null;
        session()->flash('message', 'Usuario eliminado exitosamente.');
    }


    public function render()
    {
        $users = User::where(function ($q) {
            $q->where('name', 'like', '%' . $this->query . '%')
              ->orWhere('email', 'like', '%' . $this->query . '%')
              ->orWhere('cedula', 'like', '%' . $this->query . '%');
        })->paginate(10);

        return view('livewire.users.index', compact('users'));
    }
}
