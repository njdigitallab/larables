<?php

namespace NjDigitalLab\Larables\Exceptions;

use Exception;

class AttributeException extends Exception
{
    /**
     * Table missing exception.
     *
     * @throws Laratables\Exceptions\AttributeException
     */
    public static function tableMissing(string $class): self
    {
        $message = "A table must be set through the `".$class."::table()` method";
        return new self($message);
    }

    /**
     * Element missing exception.
     *
     * @throws Laratables\Exceptions\AttributeException
     */
    public static function elementMissing(string $class): self
    {
        $message = "An element must be set through the `".$class."::element()` method";
        return new self($message);
    }
}