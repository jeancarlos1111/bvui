<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'abstract', 'year', 'category', 'status', 'pdf_path', 'user_id', 'career_id', 'location_id', 'rejection_reason'])]
class Document extends Model
{
    use HasFactory, Searchable;

    public function toSearchableArray(): array
    {
        $this->loadMissing(['career', 'location', 'user']);

        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'abstract' => $this->abstract,
            'category' => $this->category,
            'status' => $this->status,
            'year' => (int) $this->year,
            'career_id' => (int) $this->career_id,
            'location_id' => (int) $this->location_id,
            'user_id' => (int) $this->user_id,
            'career_name' => $this->career?->name,
            'location_name' => $this->location?->name,
            'user_name' => $this->user?->name,
            'created_at' => $this->created_at ? $this->created_at->timestamp : null,
        ];
    }
    public function authors()
    {
        return $this->hasMany(DocumentAuthor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
