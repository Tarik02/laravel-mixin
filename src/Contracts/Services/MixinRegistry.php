<?php

namespace Tarik02\LaravelMixin\Contracts\Services;

use Tarik02\LaravelMixin\Contracts\Data\MixedClass;

/**
 * Interface MixinRegistry
 *
 * @package Tarik02\LaravelMixin\Contracts\Services
 */
interface MixinRegistry
{
    /**
     * @return MixedClass[]
     */
    public function getClasses(): array;

    /**
     * @param string $class
     * @return MixedClass
     */
    public function class(string $class): MixedClass;

    /**
     * @param string $class
     * @param string $base
     * @return void
     */
    public function register(string $class, string $base): void;
}
