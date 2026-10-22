<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.app')]
class Edit extends Component
{
    public User $user;
    public $name;
    public $cedula;
    public $email;
    public $password;
    public $role;

    public function mount(User $user)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        if (!$authUser->hasAnyRole(['Administrador'])) {
            abort(403, 'No tienes permisos para editar usuarios.');
        }

        $this->user = $user;
        $this->name = $user->name;
        $this->cedula = $user->cedula;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name ?? '';
    }

    public function getRolesProperty()
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        if ($authUser->hasRole('Administrador')) {
            return Role::whereIn('name', ['Administrador', 'Gestor', 'Estudiante'])->get();
        }

        if ($authUser->hasRole('Gestor')) {
            return Role::whereIn('name', ['Estudiante'])->get();
        }

        return collect();
    }

    public function save()
    {
        $validRoles = $this->roles->pluck('name')->toArray();

        $this->validate([
            'name' => 'required|string|max:255',
            'cedula' => ['required', 'string', 'max:20', 'unique:users,cedula,' . $this->user->id, 'regex:/^[VE]-\d+$/'],
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:' . implode(',', $validRoles),
        ], [
            'cedula.regex' => 'La cédula debe comenzar con V- o E- seguido de números (Ej. V-12345678).',
        ]);

        $this->user->name = $this->name;
        $this->user->cedula = $this->cedula;
        $this->user->email = $this->email;

        if (!empty($this->password)) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        // Update role
        $this->user->syncRoles([$this->role]);

        session()->flash('message', 'Usuario actualizado exitosamente.');

        return redirect()->route('users');
    }

    public function render()
    {
        return view('livewire.users.edit', [
            'roles' => $this->roles
        ]);
    }
}
