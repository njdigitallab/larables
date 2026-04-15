<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait Page
{
    /**
     * Whether we should display the top bar.
     */
    protected bool $displayTopBar = true;

    /**
     * Whether we should display the bottom bar.
     */
    protected bool $displayBottomBar = true;

    /**
     * Check if we should display the top bar.
     */
    public function shouldDisplayTopBar(): bool
    {
        if (
            ! $this->shouldDisplayBulkOptions()
            && ! $this->shouldDisplayPerPageOptions()
            && ! $this->shouldDisplaySearch()
            && ! $this->shouldDisplayActiveSection()
            && ! $this->shouldDisplayTrashSection()
        ) {
            return false;
        }

        return $this->displayTopBar;
    }

    /**
     * Whether we should display the bottom bar.
     */
    public function shouldDisplayBottomBar(): bool
    {
        if (! $this->displayBottomBar) {
            return false;
        }

        if (! $this->hasData()) {
            return false;
        }

        if (! $this->shouldDisplayPagination()) {
            return false;
        }

        $data = $this->getData();

        if (! $data instanceof LengthAwarePaginator) {
            return false;
        }

        if ($data->lastPage() == 1) {
            return false;
        }

        return true;
    }
}