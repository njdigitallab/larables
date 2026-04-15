<?php

namespace NjDigitalLab\Larables\Traits;

trait BulkOptions
{
    /**
     * Whether bulk options should be displayed.
     */
    protected bool $displayBulkOptions = false;

    /**
     * The key for the bulk action.
     */
    protected string $bulkActionKey = 'bulk_action';

    /**
     * Whether bulk options should be displayed.
     */
    public function shouldDisplayBulkOptions(): bool
    {
        return $this->displayBulkOptions;
    }

    /**
     * Get the bulk action key.
     */
    public function getBulkActionKey(): string
    {
        return $this->bulkActionKey;
    }

    /**
     * Get the bulk options.
     *
     * Expected results is an array of associated arrays e.g:
     * [
     *      [
     *          'value' => 'trash',
     *          'title' => 'Trash',
     *          'route' => route('users.trash'),
     *          'request_type' => 'patch',
     *      ],
     *      [
     *          'value' => 'restore',
     *          'title' => 'Restore',
     *          'route' => route('users.restore'),
     *          'request_type' => 'patch',
     *      ]
     * ]
     *
     * The value will be submitted in the HTTP request under the $bulkActionKey name.
     * The HTTP request will be fired off to the route specified.
     * The HTTP request method will be the value defined in the request_type key.
     */
    public function getBulkOptions(): array
    {
        return [];
    }

    /**
     * Get the args for the bulk options request.
     */
    public function getArgsForBulkOptionsRequest(): array
    {
        return $this->getQueryArgs();
    }
}
