<?php

namespace App\Plivo;

use JetBrains\PhpStorm\Pure;

class PlivoMessage
{
    public string $content;
    public string $from;

    #[Pure] public static function create(string $content = ''): static
    {
        return new static($content);
    }

    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    public function content(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }
}
