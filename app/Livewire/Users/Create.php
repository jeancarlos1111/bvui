<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.app')]
class Create extends Component
{
    public $name;
    public $cedula;
    public $email;
    public $password;
    public $role;

    public function mount()
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        
        if (!$authUser->hasAnyRole(['Administrador', 'Gestor'])) {
            abort(403, 'No tienes permisos para crear usuarios.');
        }
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
            'cedula' => ['required', 'string', 'max:20', 'unique:users,cedula', 'regex:/^[VE]-\d+$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:' . implode(',', $validRoles),
        ], [
            'cedula.regex' => 'La cédula debe comenzar con V- o E- seguido de números (Ej. V-12345678).',
        ]);

        $user = User::create([
            'name' => $this->name,
            'cedula' => $this->cedula,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole($this->role);

        $this->reset(['name', 'cedula', 'email', 'password', 'role']);
        
        session()->flash('message', 'Usuario creado exitosamente.');
        
        return redirect()->route('users'); // Omitir si no se necesita redirección
    }

    public function render()
    {
        return view('livewire.users.create', [
            'roles' => $this->roles
        ]);
    }
}
