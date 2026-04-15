<?php

namespace NjDigitalLab\Larables\Traits;

use NjDigitalLab\Larables\Actions\GetCheckboxColumnContent;
use NjDigitalLab\Larables\Actions\GetCheckboxColumnTitle;

trait Checkbox
{
    /**
     * Indicate whether checkboxes should be enabled at the start of the columns.
     */
    protected bool $hasCheckbox = false;

    /**
     * The name attribute for the checkbox.
     */
    protected string $checkboxName = 'checkbox';

    /**
     * The name of the item field, that is used to set the checkbox value.
     */
    protected string $checkboxIdField = 'id';

    /**
     * Check whether checkbox is enabled.
     */
    public function hasCheckbox(): bool
    {
        return $this->hasCheckbox;
    }

    /**
     * Get the checkbox name.
     */
    public function getCheckboxName(): string
    {
        return $this->checkboxName;
    }

    /**
     * Get the items id field.
     */
    public function getCheckboxIdField(): string
    {
        return $this->checkboxIdField;
    }

    /**
     * Get the checkbox value for an item.
     */
    public function getItemCheckboxValue(mixed $item): mixed
    {
        if (isset($item->{$this->getCheckboxIdField()})) {
            return $item->{$this->getCheckboxIdField()};
        }

        if (isset($item[$this->getCheckboxIdField()])) {
            return $item[$this->getCheckboxIdField()];
        }

        return null;
    }

    /**
     * Filter if the individual row item has a checkbox.
     */
    public function itemHasCheckbox(mixed $item): bool
    {
        return $this->hasCheckbox();
    }

    /**
     * Get the checkbox column title.
     */
    public function getCheckboxColumnTitle(string $title, int $columnNumber, string $position): string
    {
        $content = "<div ".$this->getCheckboxParentContainerAtts().">";
        $content .= "<input ".$this->getCheckboxInputParentAtts().">";
        $content .= "</div>";

        return $content;
    }

    /**
     * Get the checkbox column content.
     */
    public function getCheckboxColumnContent(mixed $item, int $columnNumber, int $rowNumber): string
    {
        $content = '';

        if ($this->itemHasCheckbox($item)) {
            $content = "<div ".$this->getCheckboxChildContainerAtts().">";
            $content .= "<input ".$this->getCheckboxInputChildAtts($item).">";
            $content .= "</div>";
        }

        return $content;
    }
}