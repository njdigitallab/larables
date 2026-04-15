<?php

namespace NjDigitalLab\Larables\Traits;

trait Columns
{
    /**
     * The visible table columns.
     *
     * These should be key => value pairs, with the key being an identifier for
     * the column, while the value is the column title.
     */
    protected array $columns = [];

    /**
     * Get the table columns.
     */
    public function getColumns(): array
    {
        $columns = $this->columns;

        // Add checkbox as the first column once it is enabled
        if ($this->hasCheckbox()) {
            $columns = array_merge(['checkbox' => ''], $columns);
        }

        // Add actions as the last column once it is enabled
        if ($this->hasActions()) {
            $columns = array_merge($columns, ['actions' => '']);
        }

        return $columns;
    }

    /**
     * Get the total number of visible columns.
     */
    public function getColumnsCount(): int
    {
        return count($this->getColumns());
    }
}