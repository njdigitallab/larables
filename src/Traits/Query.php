<?php

namespace NjDigitalLab\Larables\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use NjDigitalLab\Larables\Exceptions\QueryException;

trait Query
{
    /**
     * The current query.
     */
    protected ?Builder $query = null;

    /**
     * Get whether we have a query builder to work with.
     */
    protected function hasBaseQuery(): bool
    {
        return method_exists($this, 'baseQuery');
    }

    /**
     * Get the current query to continue to build upon.
     */
    protected function getQuery(): Builder
    {
        if (is_null($this->query)) {
            $this->query = $this->getFreshQuery();
        }

        return $this->query;
    }

    /**
     * Get a fresh instance of the base query.
     *
     * @throws Laratables\Exceptions\QueryException
     */
    protected function getFreshQuery(): Builder
    {
        if (! $this->hasBaseQuery()) {
            throw QueryException::baseQueryMissing(get_class($this));
        }

        return $this->baseQuery();
    }

    /**
     * Refresh the query.
     */
    protected function refreshQuery(): self
    {
        $this->query = $this->getFreshQuery();
        return $this;
    }
}