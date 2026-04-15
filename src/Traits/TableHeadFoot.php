<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Support\Str;

Trait TableHeadFoot
{
    /**
     * Indicate whether the table footer should be displayed.
     */
    protected bool $displayTfoot = false;

    /**
     * Check if we should display the table footer.
     */
    public function shouldDisplayTfoot(): bool
    {
        return $this->displayTfoot;
    }

    /**
     * Get the column th title.
     */
    public function getTitleForColumn(string $columnId, string $columnTitle = null, int $columnNumber, string $position): ?string
    {
        if (method_exists($this, $method = 'get'.Str::studly($columnId).'ColumnTitle')) {
            return $this->$method($columnTitle, $columnNumber, $position);
        }

        if (method_exists($this, $method = 'getColumnTitle')) {
            return $this->$method($columnId, $columnTitle, $columnNumber, $position);
        }

        return $this->output($columnTitle);
    }
}