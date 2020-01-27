<?php

namespace Tarik02\LaravelMixin\Contracts\Services;

/**
 * Interface MixinCacheService
 *
 * @package Tarik02\LaravelMixin\Contracts\Services
 */
interface MixinCacheService
{
    /**
     * @return bool
     */
    public function isCached(): bool;

    /**
     * @return void
     */
    public function cacheClasses(): void;

    /**
     * @return void
     */
    public function clearCache(): void;
}
