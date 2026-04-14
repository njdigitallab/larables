<?php

namespace NjDigitalLab\Larables;

class Url
{
    /**
     * The url to work with.
     */
    protected string $url;

    /**
     * The url parts.
     */
    protected array $parts = [];

    /**
     * Create an instance of the class.
     */
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->parts = $this->getUrlParts($url);
    }

    /**
     * Get the url scheme.
     */
    public function scheme(): ?string
    {
        return $this->parts[1] ?? null;
    }

    /**
     * Get the url domain.
     */
    public function domain(): ?string
    {
        return $this->parts[2] ?? null;
    }

    /**
     * Get the url port.
     */
    public function port(): ?int
    {
        return $this->parts[3]
            ? str_replace(':', '', $this->parts[3])
            : null;
    }

    /**
     * Get the url path.
     */
    public function path(): ?string
    {
        return $this->parts[4] ?? null;
    }

    /**
     * Get the url query string.
     */
    public function query(): ?string
    {
        return $this->parts[5] ?? null;
    }

    /**
     * Get the url query string parameters.
     */
    public function queryArgs(array $except = []): array
    {
        $results = [];
        $queryString = $this->query();

        if (empty($queryString)) {
            return [];
        }

        $parameters = explode('&', $queryString);

        foreach ($parameters as $parameter) {
            $parts = explode('=', $parameter);

            if (count($parts) == 2 && ! in_array($parts[0], $except)) {
                $results[$parts[0]] = $parts[1];
            }
        }

        return $results;
    }

    /**
     * Get the url hash.
     */
    public function hash(): ?string
    {
        return $this->parts[6] ?? null;
    }

    /**
     * Check if the current request has query parameters.
     */
    public function hasQueryArgs(): bool
    {
        return ! empty($this->query());
    }

    /**
     * Get the url parts.
     */
    public function getUrlParts(string $url): array
    {
        preg_match('/^(https|http|ftp|mailto|file){0,1}:{0,1}\/{0,2}((?:[a-z0-9-]*\.{1}[a-z0-9]+)*)(:[0-9]+)*\/*([^\?|#]*)\?*([^\#]*)\#*(.*)$/', urldecode($url), $matches);
        return $matches;
    }
}
