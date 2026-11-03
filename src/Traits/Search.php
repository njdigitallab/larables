<?php

namespace NjDigitalLab\Larables\Traits;

trait Search
{
    /**
     * The columns that are searchable.
     *
     * A column does not have to be visible to the user to be searchable.
     */
    protected array $searchColumns = [];

    /**
     * The search key.
     */
    protected string $searchKey = 'search';

    /**
     * Should display the search field.
     */
    protected bool $displaySearch = false;

    /**
     * Get the columns that are searchable.
     */
    public function getSearchColumns(): array
    {
        return $this->searchColumns;
    }

    /**
     * Check if a column is sortable.
     */
    public function isColumnSearchable(string $column): bool
    {
        return in_array($column, $this->getSearchColumns());
    }

    /**
     * Get the search key.
     */
    public function getSearchKey(): string
    {
        return $this->searchKey;
    }

    /**
     * Get the search value.
     */
    public function getSearchValue(): ?string
    {
        return $_GET[$this->getSearchKey()] ?? null;
    }

    /**
     * Whether we should display the search field.
     */
    public function shouldDisplaySearch(): bool
    {
        return $this->displaySearch;
    }

    /**
     * Get the search icon markup.
     */
    public function getSearchIconHtml(): string
    {
        return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-search-icon"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>';
    }

    /**
     * Check if we have a search request.
     */
    public function hasSearchRequest(): bool
    {
        return isset($_GET[$this->getSearchKey()]);
    }

    /**
     * Handle the search request.
     */
    public function handleSearchRequest(): self
    {
        if (! $this->hasBaseQuery()) {
            return $this;
        }

        $this->handleSearchQuery($this->getSearchValue());

        return $this;
    }

    /**
     * Handle the search query.
     */
    public function handleSearchQuery(mixed $value): void
    {
        $this->getQuery()->where(function ($query) use ($value) {
            foreach ($this->getSearchColumns() as $index => $column) {
                if ($index == 0) {
                    $query = $query->where(htmlspecialchars($column), 'like', '%'.$value.'%');
                } else {
                    $query = $query->orWhere(htmlspecialchars($column), 'like', '%'.$value.'%');
                }
            }
        });
    }

    /**
     * Get the args for the search request.
     */
    public function getArgsForSearchRequest(): array
    {
        return $this->getQueryArgs([$this->getPageKey(), $this->getSearchKey()]);
    }
}