<?php

namespace NjDigitalLab\Larables\Traits;

trait Sanitize
{
    /**
     * The default output of blade.
     */
    protected function output(mixed $value): mixed
    {
        return e($value);
    }

    /**
     * The escape output of blade.
     */
    protected function escape(mixed $value): mixed
    {
        return htmlspecialchars($value);
    }
}