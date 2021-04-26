<?php

namespace App\Traits;

use App\Models\Note;

trait HasNotes
{

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
