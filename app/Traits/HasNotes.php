<?php

namespace App\Traits;

use App\Models\Note;

trait HasNotes
{

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable')
            ->orderBy('is_favorite', 'desc')
            ->orderBy('created_at', 'desc');
    }
}
