<?php

namespace Tarik02\LaravelMixin\Exceptions;

use RuntimeException;

/**
 * Class ClassLoadedException
 *
 * @package Tarik02\LaravelMixin\Exceptions
 */
class ClassLoadedException extends RuntimeException
{
    /** @var string */
    protected $class;

    /**
     * ClassLoadedException constructor.
     *
     * @param string $class
     */
    public function __construct(string $class)
    {
        parent::__construct(sprintf(
            'Class \'%s\' is already loaded, so it cannot be mixed in.',
            $class
        ));

        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}
