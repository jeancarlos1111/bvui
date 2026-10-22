<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['document_id', 'name', 'type'])]
class DocumentAuthor extends Model
{
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
