<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

Route::get('/', \App\Livewire\DocumentSearch::class)->name('home');

Route::get('dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified', 'role:Administrador|Gestor'])
    ->name('dashboard');
Route::get('/users', \App\Livewire\Users\Index::class)->name('users');
Route::get('/users/create', \App\Livewire\Users\Create::class)->name('users.create');
Route::get('/users/{user}', \App\Livewire\Users\Show::class)->name('users.show');
Route::get('/users/{user}/edit', \App\Livewire\Users\Edit::class)->name('users.edit');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/documentos', \App\Livewire\Documents\Index::class)->name('documents.index');
    Route::get('/documentos/subir', \App\Livewire\Documents\Create::class)->name('documents.create');
    Route::get('/documentos/{document}', \App\Livewire\Documents\Show::class)->name('documents.show');
    Route::get('/documentos/{document}/editar', \App\Livewire\Documents\Edit::class)->name('documents.edit');
    Route::get('/reportes', \App\Livewire\Reports\Index::class)->middleware('role:Administrador|Gestor')->name('reports.index');
    Route::get('/reportes/descargar/{export}', function (\App\Models\Export $export) {
        if ($export->user_id !== Auth::id() && !Auth::user()->hasRole('Administrador')) {
            abort(403);
        }
        if (!$export->file_path || !Storage::disk('local')->exists($export->file_path)) {
            abort(404);
        }
        return Storage::disk('local')->download($export->file_path);
    })->name('reports.download');
    Route::get('/documentos/{document}/pdf', function (\App\Models\Document $document) {
        if (!Auth::user()->hasRole('Administrador') && $document->user_id !== Auth::id()) {
            abort(403);
        }
        if (!Storage::disk('local')->exists($document->pdf_path)) {
            abort(404);
        }
        return response()->file(Storage::disk('local')->path($document->pdf_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->title . '.pdf"'
        ]);
    })->name('documents.pdf');
});

require __DIR__.'/auth.php';
