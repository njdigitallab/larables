<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Support\Str;

trait Id
{
    /**
     * The id for the table.
     */
    protected string $id;

    /**
     * Get the id for the table.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Generate an id.
     */
    protected function makeId(): string
    {
        return Str::random(36);
    }
}