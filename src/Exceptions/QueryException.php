<?php

namespace NjDigitalLab\Larables\Exceptions;

use Exception;

class QueryException extends Exception
{
    /**
     * Base query missing exception.
     *
     * @throws Laratables\Exceptions\QueryException
     */
    public static function baseQueryMissing(string $class): self
    {
        $message = $class." does not have a `baseQuery` method defined.";
        $message .= " Set a `baseQuery` method that returns an instance of the query builder (Eloquent or DB) to continue working.";

        return new self($message);
    }
}