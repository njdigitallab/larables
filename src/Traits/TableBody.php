<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Support\Str;

Trait TableBody
{
    /**
     * The no items message.
     */
    protected string $noItemMessage = 'There is nothing to display.';

    /**
     * Get the no items message.
     */
    public function getNoItemMessage(): string
    {
        return $this->noItemMessage;
    }

    /**
     * Get the row content.
     */
    public function getContentForColumn(mixed $item, string $columnId, int $columnNumber, int $rowNumber): ?string
    {
        if (method_exists($this, $method = 'get'.Str::studly($columnId).'ColumnContent')) {
            return $this->$method($item, $columnNumber, $rowNumber);
        }

        if (method_exists($this, $method = 'getColumnContent')) {
            return $this->$method($item, $columnId, $columnNumber, $rowNumber);
        }

        if (is_array($item) && array_key_exists($columnId, $item)) {
            return $this->output($item[$columnId]);
        }

        return $item->{$columnId}
            ? $this->output($item->{$columnId})
            : null;
    }
}