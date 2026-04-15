<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Support\Str;
use NjDigitalLab\Larables\Actions\GetActionsColumnContent;

trait Actions
{
    /**
     * If we should automatically handle the actions column.
     */
    protected bool $hasActions = false;

    /**
     * The list of action types that is needed by default.
     */
    protected array $actions = [];

    /**
     * The action display type.
     *
     * Accepts 'button' or 'link'.
     */
    protected string $actionDisplayType = 'link';

    /**
     * The type of content for the action.
     *
     * Accepts 'text' or 'icon'.
     */
    protected string $actionContentType = 'text';

    /**
     * Check if we should use actions.
     */
    public function hasActions(): bool
    {
        return $this->hasActions;
    }

    /**
     * Get the actions.
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * Get the action display type.
     */
    public function getActionDisplayType(): string
    {
        return $this->actionDisplayType;
    }

    /**
     * Get the action content type.
     */
    public function getActionContentType(): string
    {
        return $this->actionContentType;
    }

    /**
     * Get the actions for an individual item.
     */
    public function getItemActions(mixed $item): array
    {
        return $this->getActions();
    }

    /**
     * Get the actions column title.
     */
    public function getActionsColumnTitle(): string
    {
        return 'Actions';
    }

    /**
     * Get the actions column content.
     */
    public function getActionsColumnContent(mixed $item): string
    {
        return GetActionsColumnContent::execute($item, $this);
    }

    /**
     * Get the action text.
     */
    public function getActionText(string $action): string
    {
        $method = 'get'.Str::studly($action).'ActionText';

        return method_exists($this, $method)
            ? $this->$method()
            : ucwords(str_replace(['-', '_'], ' ', $action));
    }

    /**
     * Get the action icon markup.
     */
    public function getActionIconHtml(string $action): string
    {
        $method = 'get'.Str::studly($action).'ActionIconHtml';
        return method_exists($this, $method) ? $this->$method() : '';
    }

    /**
     * Get the query args to allow on the actions form submit.
     */
    public function getActionQueryArgs(string $action, string $actionRoute): array
    {
        $results = [];
        $whitelist = [];
        $blacklist = [];

        $globalWhitelistMethod = 'getActionsQueryArgsWhitelist';
        $globalBlacklistMethod = 'getActionsQueryArgsBlacklist';
        $whitelistMethod = 'get'.ucwords($action).'ActionsQueryArgsWhitelist';
        $blacklistMethod = 'get'.ucwords($action).'ActionsQueryArgsBlacklist';

        if (method_exists($this, $globalWhitelistMethod)) {
            $whitelist = $this->$globalWhitelistMethod($action);
        }

        if (method_exists($this, $whitelistMethod)) {
            $whitelist = array_unique(array_merge($whitelist, $this->$whitelistMethod()));
        }

        if (method_exists($this, $globalBlacklistMethod)) {
            $blacklist = $this->$globalBlacklistMethod($action);
        }

        if (method_exists($this, $blacklistMethod)) {
            $blacklist = array_unique(array_merge($blacklist, $this->$blacklistMethod()));
        }

        foreach ($this->getQueryArgs() as $key => $value) {
            if (in_array('*', $blacklist) || in_array($key, $blacklist)) {
                continue;
            }
            if (in_array('*', $whitelist) || in_array($key, $whitelist)) {
                $results[$key] = $value;
            }
        }

        return $results;
    }

    /**
     * Get the view action icon markup.
     */
    public function getViewActionIconHtml(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="laratables-view-icon">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fillRule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clipRule="evenodd" />
            </svg>';
    }

    /**
     * Get the edit action icon markup.
     */
    public function getEditActionIconHtml(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="laratables-edit-icon">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
        </svg>';
    }

    /**
     * Get the trash action icon markup.
     */
    public function getTrashActionIconHtml(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="laratables-trash-icon">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>';
    }

    /**
     * Get the restore action icon markup.
     */
    public function getRestoreActionIconHtml(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="laratables-restore-icon">
            <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
            <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
        </svg>';
    }

    /**
     * Get the delete action icon markup.
     */
    public function getDeleteActionIconHtml(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="laratables-delete-icon">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>';
    }
}