<?php

namespace NjDigitalLab\Larables\Traits;

use Illuminate\Support\Str;

trait Attributes
{
    /**
     * Get the table attributes html.
     */
    public function getTableAtts(): string
    {
        $attributes = $this->getElementAttributes('table');

        if (method_exists($this, $method = 'filterTableAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['larables-id'] = 'table';
        $attributes['larables-checkbox-name'] = $this->getCheckboxName();

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the thead attributes html.
     */
    public function getTheadAtts(): string
    {
        $attributes = $this->getElementAttributes('thead');

        if (method_exists($this, $method = 'filterTheadAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the thead tr attributes html.
     */
    public function getTheadTrAtts(): string
    {
        $tableTrAttributes = $this->getElementAttributes('table_tr');
        $theadTrAttributes = $this->getElementAttributes('thead_tr');

        if (method_exists($this, $method = 'filterTableTrAttributes')) {
            $tableTrAttributes = $this->$method($tableTrAttributes);
        }

        $attributes = $this->mergeAttributes($theadTrAttributes, $tableTrAttributes);

        if (method_exists($this, $method = 'filterTheadTrAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the thead th attributes html.
     */
    public function getTheadThAtts(string $columnId, int $columnNumber): string
    {
        $tableThAttributes = $this->getElementAttributes('table_th');
        $theadThAttributes = $this->getElementAttributes('thead_th');

        if (method_exists($this, $method = 'filterTableThAttributes')) {
            $tableThAttributes = $this->$method($tableThAttributes, $columnId, $columnNumber);
        }

        $attributes = $this->mergeAttributes($theadThAttributes, $tableThAttributes);

        if (method_exists($this, $method = 'filterTheadThAttributes')) {
            $attributes = $this->$method($attributes, $columnId, $columnNumber);
        }

        if (method_exists($this, $method = 'filter'.Str::studly($columnId).'TheadThAttributes')) {
            $attributes = $this->$method($attributes, $columnNumber);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the tbody attributes html.
     */
    public function getTbodyAtts(): string
    {
        $method = 'filterTbodyAttributes';
        $attributes = $this->getElementAttributes('tbody');

        if (method_exists($this, $method)) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get tbody tr attributes.
     */
    public function getTbodyTrAtts(mixed $item, int $rowNumber): string
    {
        $tbodyTrAttributes = $this->getElementAttributes('tbody_tr');
        $tableTrAttributes = $this->getElementAttributes('table_tr');

        if (method_exists($this, $method = 'filterTableTrAttributes')) {
            $tableTrAttributes = $this->$method($tableTrAttributes);
        }

        $attributes = $this->mergeAttributes($tbodyTrAttributes, $tableTrAttributes);

        if (method_exists($this, $method = 'filterTbodyTrAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the tbody td attributes html.
     */
    public function getTbodyTdAtts(mixed $item, string $columnId, int $columnNumber, int $rowNumber): string
    {
        $attributes = $this->getElementAttributes('tbody_td');

        if (method_exists($this, $method = 'filterTbodyTdAttributes')) {
            $attributes = $this->$method($attributes, $item, $columnId, $columnNumber, $rowNumber);
        }

        if (method_exists($this, $method = 'filter'.Str::studly($columnId).'TbodyTdAttributes')) {
            $attributes = $this->$method($attributes, $item, $columnNumber, $rowNumber);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the tbody tr no items attributes html.
     */
    public function getTbodyTrNoItemAtts(): string
    {
        $tableTrAttributes = $this->getElementAttributes('table_tr');
        $tbodyTrAttributes = $this->getElementAttributes('tbody_tr');
        $noItemsAttributes = $this->getElementAttributes('tbody_tr_no_item');

        if (method_exists($this, $method = 'filterTableTrAttributes')) {
            $tableTrAttributes = $this->$method($tableTrAttributes);
        }

        if (method_exists($this, $method = 'filterTbodyTrAttributes')) {
            $tbodyTrAttributes = $this->$method($tbodyTrAttributes);
        }

        $attributes = $this->mergeAttributes($tbodyTrAttributes, $tableTrAttributes);
        $attributes = $this->mergeAttributes($attributes, $noItemsAttributes);

        if (method_exists($this, $method = 'filterTbodyTrNoItemAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the tbody td no items attributes html.
     */
    public function getTbodyTdNoItemAtts(): string
    {
        $tbodyTdAttributes = $this->getElementAttributes('tbody_td');
        $noItemsAttributes = $this->getElementAttributes('tbody_td_no_item');

        if (method_exists($this, $method = 'filterTbodyTdAttributes')) {
            $tbodyTdAttributes = $this->$method($tbodyTdAttributes);
        }

        $attributes = $this->mergeAttributes($tbodyTdAttributes, $noItemsAttributes);

        if (method_exists($this, $method = 'filterTbodyTdNoItemAttributes')) {
            $attributes = $this->$method($attributes);
        }

        // Colspan will be added in the blade file view for no items
        if (array_key_exists('colspan', $attributes)) {
            unset($attributes['colspan']);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the tfoot attributes html.
     */
    public function getTfootAtts(): string
    {
        $attributes = $this->getElementAttributes('tfoot');

        if (method_exists($this, $method = 'filterTfootAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the tfoot tr attributes html.
     */
    public function getTfootTrAtts(): string
    {
        $tableTrAttributes = $this->getElementAttributes('table_tr');
        $tfootTrAttributes = $this->getElementAttributes('tfoot_tr');

        if (method_exists($this, $method = 'filterTableTrAttributes')) {
            $tableTrAttributes = $this->$method($tableTrAttributes);
        }

        $attributes = $this->mergeAttributes($tableTrAttributes, $tfootTrAttributes);

        if (method_exists($this, $method = 'filterTfootTrAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the tfoot th attributes html.
     */
    public function getTfootThAtts(string $columnId, int $columnNumber): string
    {
        $tableThAttributes = $this->getElementAttributes('table_th');
        $tfootThAttributes = $this->getElementAttributes('tfoot_th');

        if (method_exists($this, $method = 'filterTableThAttributes')) {
            $tableThAttributes = $this->$method($tableThAttributes, $columnId, $columnNumber);
        }

        $attributes = $this->mergeAttributes($tfootThAttributes, $tableThAttributes);

        if (method_exists($this, $method = 'filterTfootThAttributes')) {
            $attributes = $this->$method($attributes, $columnId, $columnNumber);
        }

        if (method_exists($this, $method = 'filter'.Str::studly($columnId).'TfootThAttributes')) {
            $attributes = $this->$method($attributes, $columnNumber);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the checkbox parent container attributes.
     */
    public function getCheckboxParentContainerAtts(): string
    {
        $generalAttributes = $this->getElementAttributes('checkbox_container');
        $attributes = $this->getElementAttributes('checkbox_parent_container');

        if (method_exists($this, $method = 'filterCheckboxContainerAttributes')) {
            $generalAttributes = $this->$method($generalAttributes);
        }

        $attributes = $this->mergeAttributes($generalAttributes, $attributes);

        if (method_exists($this, $method = 'filterCheckboxParentContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['larables-id'] = 'checkbox-parent-container';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the checkbox child container attributes.
     */
    public function getCheckboxChildContainerAtts(): string
    {
        $generalAttributes = $this->getElementAttributes('checkbox_container');
        $attributes = $this->getElementAttributes('checkbox_child_container');

        if (method_exists($this, $method = 'filterCheckboxContainerAttributes')) {
            $generalAttributes = $this->$method($generalAttributes);
        }

        $attributes = $this->mergeAttributes($generalAttributes, $attributes);

        if (method_exists($this, $method = 'filterCheckboxChildContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['larables-id'] = 'checkbox-child-container';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the checkbox input parent attributes html.
     */
    public function getCheckboxInputParentAtts(): string
    {
        $generalAttributes = $this->getElementAttributes('checkbox_input');
        $attributes = $this->getElementAttributes('checkbox_input_parent');

        if (method_exists($this, $method = 'filterCheckboxInputAttributes')) {
            $generalAttributes = $this->$method($generalAttributes);
        }

        $attributes = $this->mergeAttributes($generalAttributes, $attributes);

        if (method_exists($this, $method = 'filterCheckboxInputParentAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['larables-id'] = 'checkbox-parent';
        $attributes['type'] = 'checkbox';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the checkbox input child attributes html.
     */
    public function getCheckboxInputChildAtts(mixed $item): string
    {
        $generalAttributes = $this->getElementAttributes('checkbox_input');
        $attributes = $this->getElementAttributes('checkbox_input_child');

        if (method_exists($this, $method = 'filterCheckboxInputAttributes')) {
            $generalAttributes = $this->$method($generalAttributes);
        }

        $attributes = $this->mergeAttributes($generalAttributes, $attributes);

        if (method_exists($this, $method = 'filterCheckboxInputChildAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['larables-id'] = 'checkbox-child';
        $attributes['type'] = 'checkbox';
        $attributes['value'] = $this->getItemCheckboxValue($item);
        $attributes['name'] = $this->getCheckboxName().'[]';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the action container attributes html.
     */
    public function getActionContainerAtts(mixed $item): string
    {
        $attributes = $this->getElementAttributes('action_container');

        if (method_exists($this, $method = 'filterActionContainerAttributes')) {
            $attributes = $this->$method($attributes, $item);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the action button attributes html.
     */
    public function getActionButtonAtts(string $action, mixed $item): string
    {
        $actionAttributes = $this->getElementAttributes('action_button');
        $customAttributes = $this->getElementAttributes($action.'_action_button');

        if (method_exists($this, $method = 'filterActionButtonAttributes')) {
            $actionAttributes = $this->$method($actionAttributes, $item);
        }

        $attributes = $this->mergeAttributes($actionAttributes, $customAttributes);

        if (method_exists($this, $method = 'filter'.Str::studly($action).'ActionButtonAttributes')) {
            $attributes = $this->$method($attributes, $item);
        }

        $attributes['type'] = 'submit';
        $attributes['onclick'] = "event.preventDefault(); this.querySelector(".'"form"'.").submit();";

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the action link attributes html.
     */
    public function getActionLinkAtts(string $action, string $route, mixed $item): string
    {
        $actionAttributes = $this->getElementAttributes('action_link');
        $customAttributes = $this->getElementAttributes($action.'_action_link');

        if (method_exists($this, $method = 'filterActionLinkAttributes')) {
            $actionAttributes = $this->$method($actionAttributes, $item);
        }

        $attributes = $this->mergeAttributes($actionAttributes, $customAttributes);

        if (method_exists($this, $method = 'filter'.Str::studly($action).'ActionLinkAttributes')) {
            $attributes = $this->$method($attributes, $item);
        }

        $attributes['href'] = $route;
        $attributes['onclick'] = "event.preventDefault(); this.querySelector(".'"form"'.").submit();";

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the bulk options container attributes html.
     */
    public function getBulkOptionsContainerAtts(): string
    {
        $attributes = $this->getElementAttributes('bulk_options_container');

        if (method_exists($this, $method = 'filterBulkOptionsContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the bulk options select attributes html.
     */
    public function getBulkOptionsSelectAtts(): string
    {
        $selectsAttributes = $this->getElementAttributes('selects');
        $bulkAttributes = $this->getElementAttributes('bulk_options_select');

        if (method_exists($this, $method = 'filterSelectAttributes')) {
            $selectsAttributes = $this->$method($selectsAttributes);
        }

        $attributes = $this->mergeAttributes($selectsAttributes, $bulkAttributes);

        if (method_exists($this, $method = 'filterBulkOptionsSelectAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['name'] = $this->getBulkActionKey();
        $attributes['larables-id'] = 'bulk-options-select';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the per page container attributes html.
     */
    public function getPerPageContainerAtts(): string
    {
        $attributes = $this->getElementAttributes('per_page_container');

        if (method_exists($this, $method = 'filterPerPageContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the per page select attributes html.
     */
    public function getPerPageSelectAtts(): string
    {
        $selectsAttributes = $this->getElementAttributes('selects');
        $attributes = $this->getElementAttributes('per_page_select');

        if (method_exists($this, $method = 'filterSelectAttributes')) {
            $selectsAttributes = $this->$method($selectsAttributes);
        }

        $attributes = $this->mergeAttributes($selectsAttributes, $attributes);

        if (method_exists($this, $method = 'filterPerPageSelectAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['name'] = $this->getPerPageKey();
        $attributes['larables-id'] = 'per-page-select';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the search container attributes html.
     */
    public function getSearchContainerAtts(): string
    {
        $attributes = $this->getElementAttributes('search_container');

        if (method_exists($this, $method = 'filterSearchContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the search input attributes html.
     */
    public function getSearchInputAtts(): string
    {
        $attributes = $this->getElementAttributes('search_input');

        if (method_exists($this, $method = 'filterSearchInputAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['larables-id'] = 'search-input';
        $attributes['type'] = 'search';
        $attributes['name'] = $this->getSearchKey();
        $attributes['value'] = $this->getSearchValue();

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the search button attributes html.
     */
    public function getSearchButtonAtts(): string
    {
        $attributes = $this->getElementAttributes('search_button');

        if (method_exists($this, $method = 'filterSearchButtonAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['larables-id'] = 'search-button';
        $attributes['type'] = 'submit';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the active section container attributes html.
     */
    public function getActiveSectionContainerAtts(): string
    {
        $sectionAttributes = $this->getElementAttributes('section_container');
        $attributes = $this->getElementAttributes('active_section_container');

        if (method_exists($this, $method = 'filterSectionContainerAttributes')) {
            $sectionAttributes = $this->$method($sectionAttributes);
        }

        $attributes = $this->mergeAttributes($sectionAttributes, $attributes);

        if (method_exists($this, $method = 'filterActiveSectionContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the trash section container attributes html.
     */
    public function getTrashSectionContainerAtts(): string
    {
        $sectionAttributes = $this->getElementAttributes('section_container');
        $attributes = $this->getElementAttributes('trash_section_container');

        if (method_exists($this, $method = 'filterSectionContainerAttributes')) {
            $sectionAttributes = $this->$method($sectionAttributes);
        }

        $attributes = $this->mergeAttributes($sectionAttributes, $attributes);

        if (method_exists($this, $method = 'filterTrashSectionContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the active section attributes html.
     */
    public function getActiveSectionAtts(): string
    {
        $generalAttributes = $this->getElementAttributes('section');
        $currentAttributes = $this->getElementAttributes('active_section_current');
        $noneCurrentAttributes = $this->getElementAttributes('active_section_none_current');

        if (method_exists($this, $method = 'filterSectionAttributes')) {
            $generalAttributes = $this->$method($generalAttributes);
        }

        if ($this->getCurrentSection() == 'active') {
            $attributes = $this->mergeAttributes($generalAttributes, $currentAttributes);

            if (method_exists($this, $method = 'filterActiveSectionCurrentAttributes')) {
                $attributes = $this->$method($attributes);
            }
        }

        if ($this->getCurrentSection() == 'trash') {
            $attributes = $this->mergeAttributes($generalAttributes, $noneCurrentAttributes);

            if (method_exists($this, $method = 'filterActiveSectionNoneCurrentAttributes')) {
                $attributes = $this->$method($attributes);
            }
        }

        $attributes['href'] = $this->getActiveSectionRoute();
        $attributes['larables-section'] = 'active';
        $attributes['larables-section-is-current'] = ($this->getCurrentSection() !== 'trash') ? 'true' : 'false';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the trashsection attributes html.
     */
    public function getTrashSectionAtts(): string
    {
        $generalAttributes = $this->getElementAttributes('section');
        $currentAttributes = $this->getElementAttributes('trash_section_current');
        $noneCurrentAttributes = $this->getElementAttributes('trash_section_none_current');

        if (method_exists($this, $method = 'filterSectionAttributes')) {
            $generalAttributes = $this->$method($generalAttributes);
        }

        if ($this->getCurrentSection() == 'trash') {
            $attributes = $this->mergeAttributes($generalAttributes, $currentAttributes);

            if (method_exists($this, $method = 'filterTrashSectionCurrentAttributes')) {
                $attributes = $this->$method($attributes);
            }
        }

        if ($this->getCurrentSection() == 'active') {
            $attributes = $this->mergeAttributes($generalAttributes, $noneCurrentAttributes);

            if (method_exists($this, $method = 'filterTrashSectionNoneCurrentAttributes')) {
                $attributes = $this->$method($attributes);
            }
        }

        $attributes['href'] = $this->getTrashSectionRoute();
        $attributes['larables-section'] = 'trash';
        $attributes['larables-section-is-current'] = ($this->getCurrentSection() === 'trash') ? 'true' : 'false';

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the wrapper attributes html.
     */
    public function getWrapperAtts(): string
    {
        $attributes = $this->getElementAttributes('wrapper');

        if (method_exists($this, $method = 'filterWrapperAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the top bar container attributes html.
     */
    public function getTopBarContainerAtts(): string
    {
        $attributes = $this->getElementAttributes('top_bar_container');

        if (method_exists($this, $method = 'filterTopBarContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the bottom bar container attributes html.
     */
    public function getBottomBarContainerAtts(): string
    {
        $attributes = $this->getElementAttributes('bottom_bar_container');

        if (method_exists($this, $method = 'filterBottomBarContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the column container attributes html.
     */
    public function getColumnTitleContainerAtts(): string
    {
        $attributes = $this->getElementAttributes('column_title_container');

        if (method_exists($this, $method = 'filterColumnTitleContainerAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the column title attributes html.
     */
    public function getColumnTitleAtts(): string
    {
        $attributes = $this->getElementAttributes('column_title');

        if (method_exists($this, $method = 'filterColumTitleAttributes')) {
            $attributes = $this->$method($attributes);
        }

        return $this->parseAttributesToString($attributes);
    }

    /**
     * Get the sort button attributes html.
     */
    public function getSortButtonAtts(): string
    {
        $attributes = $this->getElementAttributes('sort_button');

        if (method_exists($this, $method = 'filterSortButtonAttributes')) {
            $attributes = $this->$method($attributes);
        }

        $attributes['type'] = 'submit';
        $attributes['larables-id'] = 'column-sort-button';

        return $this->parseAttributesToString($attributes);
    }
}