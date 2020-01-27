<?php

namespace Tarik02\LaravelMixin\Providers;

use Illuminate\Support\ServiceProvider;
use Tarik02\LaravelMixin\Console\Commands\CacheClearCommand;
use Tarik02\LaravelMixin\Console\Commands\CacheCommand;
use Tarik02\LaravelMixin\Contracts\Services\CustomClassLoader as CustomClassLoaderContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinCacheService as MixinCacheServiceContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinGeneratorService as MixinGeneratorServiceContract;
use Tarik02\LaravelMixin\Contracts\Services\MixinRegistry as MixinRegistryContract;
use Tarik02\LaravelMixin\Services\CustomClassLoader;
use Tarik02\LaravelMixin\Services\MixinCacheService;
use Tarik02\LaravelMixin\Services\MixinGeneratorService;
use Tarik02\LaravelMixin\Services\MixinRegistry;

/**
 * Class LaravelMixinServiceProvider
 *
 * @package Tarik02\LaravelMixin\Providers
 */
class LaravelMixinServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(CustomClassLoaderContract::class, CustomClassLoader::class);
        $this->app->singleton(MixinCacheServiceContract::class, MixinCacheService::class);
        $this->app->singleton(MixinGeneratorServiceContract::class, MixinGeneratorService::class);
        $this->app->singleton(MixinRegistryContract::class, MixinRegistry::class);

        $this->app->when(CustomClassLoader::class)
            ->needs('$fallbackLoader')
            ->give(function () {
                return require $this->app->basePath('vendor/autoload.php');
            })
        ;

        $this->app->alias(MixinRegistryContract::class, 'mixin');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CacheCommand::class,
                CacheClearCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laravel-mixin');

        $this->registerCustomClassLoader();
    }

    /**
     * @return void
     */
    public function registerCustomClassLoader(): void
    {
        $this->app->make(CustomClassLoaderContract::class)->register();
    }
}
