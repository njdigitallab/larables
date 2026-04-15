<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait Data
{
    /**
     * Check if we have data to work with.
     */
    public function hasData(): bool
    {
        $data = $this->getData();

        if ($data instanceof Collection) {
            return $data->isNotEmpty();
        }

        if ($data instanceof LengthAwarePaginator) {
            return $data->total() >= 1;
        }

        return ! empty($data);
    }

    /**
     * Check if the data is iterable.
     */
    public function dataIsIterable(): bool
    {
        $data = $this->getData();
        return is_iterable($data) || is_object($data);
    }

    /**
     * Get the data to work with.
     */
    public function getData(): iterable
    {
        if ($data = $this->cache->get('data')) {
            return $data;
        }

        $data = $this->generateData();

        $this->cache->put('data', $data, 0);

        return $data;
    }

    /**
     * Generate the data to work with.
     *
     * By default, this relies on there being a base query to work with. By
     * base query, we mean an instance of the Illuminate\Database\Query\Builder.
     *
     * If you wish for your data to be generated without the query builder, this
     * is the method to override.
     */
    protected function generateData(): iterable
    {
        if (! $this->hasBaseQuery()) {
            return [];
        }

        if (! $this->shouldPaginate()) {
            return $this->getQuery()->get();
        }

        return $this->getQuery()->paginate(
            $this->getPerPageTotal(), ['*'], $this->getPageKey()
        );
    }
}