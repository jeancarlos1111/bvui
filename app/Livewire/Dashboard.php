<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        $user = Auth::user();
        $query = Document::query();

        $role = 'Usuario';
        if ($user->hasRole('Administrador')) {
            $role = 'Administrador';
            $title = 'Métricas Generales del Sistema';
            $subtitle = 'Vista global de todos los documentos en la biblioteca virtual.';
        } elseif ($user->hasRole('Gestor')) {
            $role = 'Gestor';
            $query->where('user_id', $user->id);
            $title = 'Mis Métricas de Gestión';
            $subtitle = 'Resumen de los documentos que has subido al sistema.';
        } else {
            // Fallback (though middleware prevents this)
            $title = 'Métricas';
            $subtitle = '';
        }

        $metrics = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'Pendiente')->count(),
            'approved' => (clone $query)->where('status', 'Aprobado')->count(),
            'rejected' => (clone $query)->where('status', 'Rechazado')->count(),
        ];

        // Categories metrics
        $categoriesRaw = (clone $query)
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();
            
        $categories = [
            'TEG' => 0,
            'Pasantía' => 0,
            'Proyecto' => 0,
            'Servicio Comunitario' => 0,
        ];

        foreach ($categoriesRaw as $cat) {
            if (array_key_exists($cat->category, $categories)) {
                $categories[$cat->category] = $cat->count;
            }
        }

        return view('livewire.dashboard', [
            'metrics' => $metrics,
            'categories' => $categories,
            'role' => $role,
            'title' => $title,
            'subtitle' => $subtitle,
        ]);
    }
}
