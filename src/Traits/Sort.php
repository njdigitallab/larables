<?php

namespace NjDigitalLab\Larables\Traits;

trait Sort
{
    /**
     * The columns that are sortable.
     *
     * Only visible columns can be sortable.
     */
    protected array $sortColumns = [];

    /**
     * The sort by key.
     */
    protected string $sortKey = 'sort_by';

    /**
     * The order key.
     */
    protected string $orderKey = 'order';

    /**
     * Whether to allow multiple sorting.
     */
    protected bool $allowMultipleSorting = false;

    /**
     * Get the columns that are sortable.
     */
    public function getSortColumns(): array
    {
        return $this->sortColumns;
    }

    /**
     * Check if a column is sortable.
     */
    public function isColumnSortable(string $column): bool
    {
        return in_array($column, $this->getSortColumns());
    }

    /**
     * Get the sortable key.
     */
    public function getSortKey(): string
    {
        return $this->sortKey;
    }

    /**
     * Get the sort value.
     */
    public function getSortValue(): ?string
    {
        return $_GET[$this->getSortKey()] ?? null;
    }

    /**
     * Get the order key.
     */
    public function getOrderKey(): string
    {
        return $this->orderKey;
    }

    /**
     * Get the order value.
     */
    public function getOrderValue(): ?string
    {
        return $_GET[$this->getOrderKey()] ?? null;
    }

    /**
     * Check if we should allow multiple sorting.
     */
    public function allowMultipleSorting(): bool
    {
        return $this->allowMultipleSorting;
    }

    /**
     * Get the column order value, 'asc' or 'desc'.
     */
    public function getColumnOrderValue(string $column): string
    {
        $sorts = $this->getSortValue();
        $orders = $this->getOrderValue();

        $sorts = empty($sorts) ? [] : explode(',', $sorts);
        $orders = empty($orders) ? [] : explode(',', $orders);

        if (! in_array($column, $sorts)) {
            return 'asc';
        }

        $position = array_search($column, $sorts);

        return $orders[$position] ?? 'asc';
    }

    /**
     * Get the asc sort icon markup.
     */
    public function getAscSortIconHtml(): string
    {
        return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="arrow-down"><path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
    }

    /**
     * Get the desc sort icon markup.
     */
    public function getDescSortIconHtml(): string
    {
        return '<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="arrow-up"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
    }

    /**
     * Get the form column sort and order attributes.
     */
    public function getColumnArgsForSorting(string $columnId): array
    {
        if ($this->allowMultipleSorting()) {
            return $this->getColumnArgsForMultipleSorting($columnId);
        }

        return $this->getColumnArgsForSingularSorting($columnId);
    }

    /**
     * Get the form column sort and order attributes for single sorting.
     */
    public function getColumnArgsForSingularSorting(string $columnId): array
    {
        $sort = $this->getSortValue();
        $order = $this->getOrderValue();

        return [
            $this->getSortKey() => $columnId,
            $this->getOrderKey() => ($order == 'asc') ? 'desc' : 'asc',
        ];
    }

    /**
     * Get the form column sort and order attributes for multiple sorting.
     */
    public function getColumnArgsForMultipleSorting(string $columnId): array
    {
        $sorts = $this->getSortValue();
        $orders = $this->getOrderValue();

        $sorts = empty($sorts) ? [] : explode(',', $sorts);
        $orders = empty($orders) ? [] : explode(',', $orders);

        if (! in_array($columnId, $sorts)) {
            $sorts[] = $columnId;
        }

        $columnPosition = array_search($columnId, $sorts);

        if (isset($orders[$columnPosition])) {
            $orders[$columnPosition] = ($orders[$columnPosition] == 'asc') ? 'desc' : 'asc';
        } else {
            $orders[] = 'asc';
        }

        return [
            $this->getSortKey() => implode(',', $sorts),
            $this->getOrderKey() => implode(',', $orders),
        ];
    }

    /**
     * Get the sort data.
     */
    public function getSortData(): array
    {
        $results = [];
        $defaultOrder = 'asc';

        $columns = explode(',', $this->getSortValue());
        $orders = explode(',', $this->getOrderValue());

        if (empty($columns)) {
            return [];
        }

        foreach ($columns as $index => $column) {
            $results[trim($column)] = $orders[$index] ?? $defaultOrder;
        }

        return $results;
    }

    /**
     * Check if we have a sort request.
     */
    public function hasSortRequest(): bool
    {
        return isset($_GET[$this->getSortKey()]);
    }

    /**
     * Handle the sort request.
     */
    protected function handleSortRequest(): self
    {
        if (! $this->hasBaseQuery()) {
            return $this;
        }

        if (! empty($data = $this->getSortData())) {
            $this->handleSortQuery($data);
        }

        return $this;
    }

    /**
     * Handle the sort query.
     */
    protected function handleSortQuery(array $columns): void
    {
        foreach ($columns as $column => $order) {
            $this->getQuery()->orderBy(htmlspecialchars($column), $order);
        }
    }

    /**
     * Get the args for the sort request.
     */
    public function getArgsForSortRequest(string $columnId): array
    {
        $queryArgs = $this->getQueryArgs([
            $this->getPageKey(), $this->getSortKey(), $this->getOrderKey()
        ]);

        return array_merge($queryArgs, $this->getColumnArgsForSorting($columnId));
    }
}