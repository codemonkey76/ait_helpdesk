<?php

namespace App\Traits;

trait HasPinnable
{
    public function pin()
    {
        $this->update(['is_pinned' => true]);
    }
    public function unpin()
    {
        $this->update(['is_pinned' => false]);
    }
}
