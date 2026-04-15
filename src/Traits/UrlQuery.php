<?php

namespace NjDigitalLab\Larables\Traits;

use NjDigitalLab\Larables\Url;

trait UrlQuery
{
    /**
     * The url instance.
     */
    protected Url $url;

    /**
     * Check if the current request has query parameters.
     */
    public function hasQueryArgs(): bool
    {
        return $this->url()->hasQueryArgs();
    }

    /**
     * Get the currently submitted url query string parameters.
     */
    public function getQueryArgs(array $except = []): array
    {
        return $this->url()->queryArgs($except);
    }

    /**
     * Get the query string for the current $_GET request.
     */
    public function getQueryString(): ?string
    {
        return $this->url()->query();
    }

    /**
     * A builder that allows us to build on the Url instance.
     */
    public function url(): Url
    {
        return $this->url;
    }
}