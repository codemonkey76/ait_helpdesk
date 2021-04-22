<?php

namespace App\Traits;

trait HasNotes
{

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}