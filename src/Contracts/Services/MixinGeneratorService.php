<?php

namespace Tarik02\LaravelMixin\Contracts\Services;

use Tarik02\LaravelMixin\Contracts\Data\MixedClass;

/**
 * Interface MixinGeneratorService
 *
 * @package Tarik02\LaravelMixin\Contracts\Services
 */
interface MixinGeneratorService
{
    /**
     * @param MixedClass $class
     * @return string
     */
    public function getClassFileName(MixedClass $class): string;

    /**
     * @param MixedClass $class
     * @param string $fileName
     */
    public function generateClass(MixedClass $class, string $fileName): void;

    /**
     * @return void
     */
    public function generateAllClasses(): void;
}
