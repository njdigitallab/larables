<?php

namespace NjDigitalLab\Larables\Traits;

trait Sections
{
    /**
     * Whether to display the active section.
     */
    protected bool $displayActiveSection = true;

    /**
     * Whether to display the trash section.
     */
    protected bool $displayTrashSection = false;

    /**
     * The section that is current. 'active' and 'trash' is reserved by us.
     */
    protected string $currentSection = 'active';

    /**
     * The key for the section used in the $_GET request.
     */
    protected string $sectionKey = 'section';

    /**
     * Check if the active section should be displayed.
     */
    public function shouldDisplayActiveSection(): bool
    {
        return $this->displayActiveSection;
    }

    /**
     * Check if the trash section should be displayed.
     */
    public function shouldDisplayTrashSection(): bool
    {
        return $this->displayTrashSection;
    }

    /**
     * Get the section that is current.
     */
    public function getCurrentSection(): string
    {
        return $this->currentSection;
    }

    /**
     * Get the section key to use in the $_GET request.
     */
    public function getSectionKey(): string
    {
        return $this->sectionKey;
    }

    /**
     * Get the route for the active section.
     */
    public function getActiveSectionRoute(): string
    {
        return '#';
    }

    /**
     * Get the route for the trash section.
     */
    public function getTrashSectionRoute(): string
    {
        return '#';
    }

    /**
     * Get the active section image markup.
     */
    public function getActiveSectionIconHtml(): string
    {
        return '<svg width="28" height="28" viewBox="0 0 20 20" fill="currentColor" class="laratables-section-icon laratables-active-section-icon"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>';
    }

    /**
     * Get the trash section image markup.
     */
    public function getTrashSectionIconHtml(): string
    {
        return '<svg width="28" height="28" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
    }
}