<?php

namespace Tarik02\LaravelMixin\Services;

use Tarik02\LaravelMixin\Contracts\Services\MixinCacheService as MixinCacheServiceContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinGeneratorService as MixinGeneratorServiceContract;

/**
 * Class MixinCacheService
 *
 * @package Tarik02\LaravelMixin\Services
 */
class MixinCacheService implements MixinCacheServiceContract
{
    /** @var MixinGeneratorServiceContract */
    private $generator;

    /** @var bool|null */
    private $isCached = null;

    /**
     * MixinCacheService constructor.
     *
     * @param MixinGeneratorServiceContract $generator
     */
    public function __construct(MixinGeneratorServiceContract $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return bool
     */
    public function isCached(): bool
    {
        if ($this->isCached === null) {
            $this->isCached = file_exists(storage_path('framework/mixin/.cached'));
        }

        return $this->isCached;
    }

    /**
     * @return void
     */
    public function cacheClasses(): void
    {
        $this->generator->generateAllClasses();

        touch(storage_path('framework/mixin/.cached'));
    }

    /**
     * @return void
     */
    public function clearCache(): void
    {
        $path = storage_path('framework/mixin');

        $files = array_diff(scandir($path), ['.', '..', '.gitignore']);

        foreach ($files as $file) {
            unlink("{$path}/{$file}");
        }
    }
}
