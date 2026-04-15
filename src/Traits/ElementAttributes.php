<?php

namespace NjDigitalLab\Larables\Traits;

trait ElementAttributes
{
    /**
     * The elements attributes.
     */
    protected array $elementAttributes = [
        'table' => [],
        'table_tr' => [],
        'table_th' => [],
        'thead' => [],
        'thead_tr' => [],
        'thead_th' => [],
        'tbody' => [],
        'tbody_tr' => [],
        'tbody_td' => [],
        'tbody_tr_no_item' => [],
        'tbody_td_no_item' => [],
        'tfoot' => [],
        'tfoot_tr' => [],
        'tfoot_th' => [],
        'checkbox_container' => [],
        'checkbox_parent_container' => [],
        'checkbox_child_container' => [],
        'checkbox_input' => [],
        'checkbox_input_parent' => [],
        'checkbox_input_child' => [],
        'action_container' => [],
        'action_button' => [],
        'action_link' => [],
        'view_action_button' => [],
        'edit_action_button' => [],
        'trash_action_button' => [],
        'restore_action_button' => [],
        'delete_action_button' => [],
        'view_action_link' => [],
        'edit_action_link' => [],
        'trash_action_link' => [],
        'restore_action_link' => [],
        'delete_action_link' => [],
        'wrapper_container' => [],
        'top_bar_container' => [],
        'bottom_bar_container' => [],
        'selects' => [],
        'bulk_options_select' => [],
        'per_page_select' => [],
        'search_input' => [],
        'search_button' => [],
        'section' => [],
        'active_section_current' => [],
        'trash_section_current' => [],
        'active_section_none_current' => [],
        'trash_section_none_current' => [],
        'bulk_options_container' => [],
        'per_page_container' => [],
        'search_container' => [],
        'section_container' => [],
        'active_section_container' => [],
        'trash_section_container' => [],
        'column_title_container' => [],
        'column_title' => [],
        'sort_button' => [],
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