<?php

namespace Tarik02\LaravelMixin\Services;

use Tarik02\LaravelMixin\Contracts\Data\MixedClass as MixedClassContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinRegistry as MixinRegistryContract;
use Tarik02\LaravelMixin\Data\MixedClass;
use Tarik02\LaravelMixin\Exceptions\ClassAlreadyRegisteredException;
use Tarik02\LaravelMixin\Exceptions\ClassLoadedException;

/**
 * Class MixinRegistry
 *
 * @package Tarik02\LaravelMixin\Services
 */
class MixinRegistry implements MixinRegistryContract
{
    /** @var MixedClassContract[] */
    private $classes = [];

    /**
     * @return MixedClassContract[]
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @param string $class
     * @return MixedClassContract
     */
    public function class(string $class): MixedClassContract
    {
        return $this->classes[$class];
    }

    /**
     * @param string $class
     * @param string $base
     */
    public function register(string $class, string $base): void
    {
        if (class_exists($class, false)) {
            throw new ClassLoadedException($class);
        }

        if (isset($this->classes[$class])) {
            throw new ClassAlreadyRegisteredException($this->classes[$class]);
        }

        $this->classes[$class] = new MixedClass($class, $base);
    }
}
