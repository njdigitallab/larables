<?php

namespace NjDigitalLab\Larables;

use Illuminate\Cache\ArrayStore;

abstract class Table
{
    /**
     * The cache store.
     */
    protected ArrayStore $cache;

    /**
     * Create an instance of the class.
     */
    public function __construct()
    {
        $this->cache = new ArrayStore;
        $this->url = new Url(url()->full());
        $this->id = $this->makeId();
    }

    /**
     * Make an instance of the table.
     */
    public static function make(): self
    {
        $table = new static;

        if ($table->hasSearchRequest()) {
            $table->handleSearchRequest();
        }

        if ($table->hasSortRequest()) {
            $table->handleSortRequest();
        }

        return $table;
    }
}