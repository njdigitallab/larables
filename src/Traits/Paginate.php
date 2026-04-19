<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait Paginate
{
    /**
     * The key that holds the current page value.
     */
    protected string $pageKey = 'page';

    /**
     * The key that holds the total items per page value.
     */
    protected string $perPageKey = 'per_page';

    /**
     * The default number of items to display per page.
     */
    protected int $perPageTotal = 15;

    /**
     * Get the maximum per page total.
     * This is a fail safe so that users don't crash the browser by overloading the request.
     */
    protected int $maxPerPageTotal = 1000;

    /**
     * Indicate whether we should paginate the query.
     */
    protected bool $paginate = true;

    /**
     * Indicate whether we should display the pagination links.
     */
    protected bool $displayPagination = true;

    /**
     * Whether we should display the total number of items per page options.
     */
    protected bool $displayPerPageOptions = false;

    /**
     * Get the page key.
     */
    public function getPageKey(): string
    {
        return $this->pageKey;
    }

    /**
     * Get the per page key.
     */
    public function getPerPageKey(): string
    {
        return $this->perPageKey;
    }

    /**
     * Get the per page total.
     */
    public function getPerPageTotal(): int
    {
        if ($this->hasPerPageRequest()) {
            return $this->getRequestedPerPageTotal();
        }

        return $this->perPageTotal;
    }

    /**
     * Get the maximum per page total.
     */
    public function getMaxPerPageTotal(): int
    {
        return $this->maxPerPageTotal;
    }

    /**
     * Check if we have a per page request.
     */
    public function hasPerPageRequest(): bool
    {
        return isset($_GET[$this->getPerPageKey()]);
    }

    /**
     * Get the requested pagination total.
     */
    public function getRequestedPerPageTotal(): int
    {
        $total = $_GET[$this->getPerPageKey()] ?? 0;

        if (! is_numeric($total)) {
            return 0;
        }

        if ($total > $this->getMaxPerPageTotal()) {
            return $this->getMaxPerPageTotal();
        }

        return $total;
    }

    /**
     * Check if we have a per page total.
     */
    public function hasPerPageTotal(): bool
    {
        return ! empty($this->getPerPageTotal());
    }

    /**
     * Get the page number.
     */
    public function getPageNumber(): int
    {
        $page = $_GET[$this->getPageKey()] ?? 1;

        if (! is_numeric($page) || $page == 0) {
            return 1;
        }

        return $page;
    }

    /**
     * Get the indicator if we should paginate.
     */
    public function shouldPaginate(): bool
    {
        return $this->paginate;
    }

    /**
     * Get the indicator of whether we should display the pagination links.
     */
    public function shouldDisplayPagination(): bool
    {
        return $this->displayPagination;
    }

    /**
     * Display the pagination links.
     */
    public function displayPagination(): ?string
    {
        if (! $this->hasBaseQuery()) {
            return null;
        }

        $data = $this->getData();

        if (! $data instanceof LengthAwarePaginator) {
            return null;
        }

        return $data->withQueryString()->links();
    }

    /**
     * Whether we should display per page options.
     */
    public function shouldDisplayPerPageOptions(): bool
    {
        return $this->displayPerPageOptions;
    }

    /**
     * Get the per page options.
     */
    public function getPerPageOptions(): array
    {
        return [
            15 => 15,
            25 => 25,
            50 => 50,
            100 => 100,
            250 => 250,
        ];
    }

    /**
     * Get the args for the per page request.
     */
    public function getArgsForPerPageRequest(): array
    {
        return $this->getQueryArgs([$this->getPageKey(), $this->getPerPageKey()]);
    }
}