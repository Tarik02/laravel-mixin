<?php

namespace Tarik02\LaravelMixin\Services;

use Tarik02\LaravelMixin\Contracts\Services\CustomClassLoader as CustomClassLoaderContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinCacheService as MixinCacheServiceContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinGeneratorService as MixinGeneratorServiceContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinRegistry as MixinRegistryContract;

/**
 * Class CustomClassLoader
 *
 * @package Tarik02\LaravelMixin\Services
 */
final class CustomClassLoader implements CustomClassLoaderContract
{
    /** @var MixinRegistryContract */
    private $registry;

    /** @var MixinGeneratorServiceContract */
    private $generator;

    /** @var MixinCacheServiceContract */
    private $cache;

    /** @var mixed|null */
    private $fallbackLoader;

    /**
     * CustomClassLoader constructor.
     *
     * @param MixinRegistryContract $registry
     * @param MixinGeneratorServiceContract $generator
     * @param MixinCacheServiceContract $cache
     * @param mixed|null $fallbackLoader
     */
    public function __construct(
        MixinRegistryContract $registry,
        MixinGeneratorServiceContract $generator,
        MixinCacheServiceContract $cache,
        $fallbackLoader = null
    ) {
        $this->registry = $registry;
        $this->generator = $generator;
        $this->cache = $cache;
        $this->fallbackLoader = $fallbackLoader;
    }

    /**
     * @return void
     */
    public function register(): void
    {
        if (
            $this->fallbackLoader !== null &&
            method_exists($this->fallbackLoader, 'unregister')
        ) {
            $this->fallbackLoader->unregister();
        }

        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * @param string $name
     */
    public function loadClass(string $name): void
    {
        $classes = $this->registry->getClasses();

        if (isset($classes[$name])) {
            $class = $classes[$name];
            $fileName = $this->generator->getClassFileName($class);

            if ($this->cache->isCached()) {
                include $fileName;
                return;
            } else {
                $this->generator->generateClass($class, $fileName);

                include $fileName;
                return;
            }
        }

        if ($this->fallbackLoader !== null) {
            $this->fallbackLoader->loadClass($name);
        }
    }
}
