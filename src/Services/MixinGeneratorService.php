<?php

namespace Tarik02\LaravelMixin\Services;

use Tarik02\LaravelMixin\Contracts\Data\MixedClass as MixedClassContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinGeneratorService as MixinGeneratorServiceContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinRegistry as MixinRegistryContract;

/**
 * Class MixinGeneratorService
 *
 * @package Tarik02\LaravelMixin\Services
 */
class MixinGeneratorService implements MixinGeneratorServiceContract
{
    /** @var MixinRegistryContract */
    protected $registry;

    /**
     * MixinGeneratorService constructor.
     *
     * @param MixinRegistryContract $registry
     */
    public function __construct(MixinRegistryContract $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param MixedClassContract $class
     * @return string
     */
    public function getClassFileName(MixedClassContract $class): string
    {
        $hash = md5($class->getName());

        return storage_path("framework/mixin/{$hash}.php");
    }

    /**
     * @param MixedClassContract $class
     * @param string $fileName
     * @return void
     */
    public function generateClass(MixedClassContract $class, ?string $fileName = null): void
    {
        if ($fileName === null) {
            $fileName = $this->getClassFileName($class);
        }

        $source = view('laravel-mixin::mixin', compact('class'))->render();

        file_put_contents($fileName, $source);
    }

    /**
     * @return void
     */
    public function generateAllClasses(): void
    {
        $classes = $this->registry->getClasses();

        foreach ($classes as $class) {
            $fileName = $this->getClassFileName($class);

            $this->generateClass($class, $fileName);
        }
    }
}
