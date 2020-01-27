<?php

namespace Tarik02\LaravelMixin\Exceptions;

use RuntimeException;
use Tarik02\LaravelMixin\Contracts\Data\MixedClass;

/**
 * Class ClassAlreadyRegisteredException
 *
 * @package Tarik02\LaravelMixin\Exceptions
 */
class ClassAlreadyRegisteredException extends RuntimeException
{
    /** @var MixedClass */
    protected $class;

    /**
     * ClassLoadedException constructor.
     *
     * @param MixedClass $class
     */
    public function __construct(MixedClass $class)
    {
        parent::__construct(sprintf(
            'Class \'%s\' is already registered (with base class \'%s\').',
            $class->getName(),
            $class->getBaseClass()
        ));

        $this->class = $class;
    }

    /**
     * @return MixedClass
     */
    public function getClass(): MixedClass
    {
        return $this->class;
    }
}
