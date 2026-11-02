<?php

namespace NjDigitalLab\Larables\Traits;

trait ElementAttributes
{
    /**
     * The elements attributes.
     */
    protected array $elementAttributes = [
        'table' => ['class' => 'larables-table'],
        'table_tr' => ['class' => 'larables-tr'],
        'table_th' => ['class' => 'larables-th'],
        'thead' => ['class' => 'larables-thead'],
        'thead_tr' => ['class' => 'larables-thead-tr'],
        'thead_th' => ['class' => 'larables-thead-th'],
        'tbody' => ['class' => 'larables-tbody'],
        'tbody_tr' => ['class' => 'larables-tbody-tr'],
        'tbody_td' => ['class' => 'larables-tbody-td'],
        'tbody_tr_no_item' => ['class' => 'larables-tbody-tr-no-item'],
        'tbody_td_no_item' => ['class' => 'larables-tbody-no-item'],
        'tfoot' => ['class' => 'larables-tfoot'],
        'tfoot_tr' => ['class' => 'larables-tfoot-tr'],
        'tfoot_th' => ['class' => 'larables-tfoot-th'],
        'checkbox_container' => ['class' => 'larables-checkbox-container'],
        'checkbox_parent_container' => ['class' => 'larables-checkbox-parent-container'],
        'checkbox_child_container' => ['class' => 'larables-checkbox-child-container'],
        'checkbox_input' => ['class' => 'larables-checkbox-input'],
        'checkbox_input_parent' => ['class' => 'larables-checkbox-input-parent'],
        'checkbox_input_child' => ['class' => 'larables-checkbox-input-child'],
        'action_container' => ['class' => 'larables-action-container'],
        'action_button' => ['class' => 'larables-action-button'],
        'action_link' => ['class' => 'larables-action-link'],
        'view_action_button' => ['class' => 'larables-view-action-button'],
        'edit_action_button' => ['class' => 'larables-edit-action-button'],
        'trash_action_button' => ['class' => 'larables-trash-action-button'],
        'restore_action_button' => ['class' => 'larables-restore-action-button'],
        'delete_action_button' => ['class' => 'larables-destroy-action-button'],
        'view_action_link' => ['class' => 'larables-view-action-link'],
        'edit_action_link' => ['class' => 'larables-edit-action-link'],
        'trash_action_link' => ['class' => 'larables-trash-action-link'],
        'restore_action_link' => ['class' => 'larables-restore-action-link'],
        'delete_action_link' => ['class' => 'larables-destroy-action-link'],
        'wrapper' => ['class' => 'larables-wrapper'],
        'top_bar_container' => ['class' => 'larables-top-bar-container'],
        'bottom_bar_container' => ['class' => 'larables-bottom-bar-container'],
        'selects' => ['class' => 'larables-selects'],
        'bulk_options_container' => ['class' => 'larables-bulk-options-container'],
        'bulk_options_select' => ['class' => 'larables-bulk-options-select'],
        'per_page_container' => ['class' => 'larables-per-page-container'],
        'per_page_select' => ['class' => 'larables-per-page-select'],
        'search_container' => ['class' => 'larables-search-container'],
        'search_input' => [
            'class' => 'larables-search-input',
            'placeholder' => 'Search...',
        ],
        'search_button' => ['class' => 'larables-search-button'],
        'section_container' => ['class' => 'larables-section-container'],
        'active_section_container' => ['class' => 'larables-active-section-container'],
        'trash_section_container' => ['class' => 'larables-trash-section-container'],
        'section' => ['class' => 'larables-section'],
        'active_section_current' => ['class' => 'larables-active-section-current'],
        'active_section_none_current' => ['class' => 'larables-active-section-none-current'],
        'trash_section_current' => ['class' => 'larables-trash-section-current'],
        'trash_section_none_current' => ['class' => 'larables-trash-section-none-current'],
        'column_title_container' => ['class' => 'larables-column-title-container'],
        'column_title' => ['class' => 'larables-column-title'],
        'sort_button' => ['class' => 'larables-sort-button'],
    ];

    /**
     * Get the element attributes.
     */
    public function getElementAttributes(string $element): array
    {
        $attributes = [];
        $elements = func_get_args();
        
        foreach ($elements as $element) {
            foreach ($this->elementAttributes[$element] ?? [] as $attribute => $value) {
                $attributes[$attribute][] = $value;
            }
        }

        return $attributes;
    }

    /**
     * Merge a list of attributes.
     */
    public function mergeAttributes(array $primary, array $secondary): array
    {
        foreach ($secondary as $attribute => $value) {
            $primary[$attribute] = [implode(
                ' ', array_unique(array_merge($primary[$attribute] ?? [], $value))
            )];
        }

        return $primary;
    }

    /**
     * Parse a list of attributes for output as one string.
     */
    public function parseAttributesToString(array $attributes): string
    {
        $results = [];

        foreach ($attributes as $attribute => $value) {
            $results[] = $this->parseAttributeToString($attribute, $value);
        }

        return implode(' ', $results);
    }

    /**
     * Parse an attribute pair for output.
     */
    public function parseAttributeToString(string $attribute, $value): string
    {
        if (is_array($value)) {
            $value = implode(' ', array_unique($value));
        } else {
            $value = implode(' ', array_unique(explode(' ', $value)));
        }

        return $attribute."='".$value."'";
    }
}