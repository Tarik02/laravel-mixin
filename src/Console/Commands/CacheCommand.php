<?php

namespace Tarik02\LaravelMixin\Console\Commands;

use Illuminate\Console\Command;
use Tarik02\LaravelMixin\Contracts\Services\MixinCacheService;

/**
 * Class CacheCommand
 *
 * @package Tarik02\LaravelMixin\Console\Commands
 */
class CacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mixin:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache all mixins';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->getLaravel()->make(MixinCacheService::class)->cacheClasses();
    }
}
