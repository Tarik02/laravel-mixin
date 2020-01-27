<?php

namespace Tarik02\LaravelMixin\Console\Commands;

use Illuminate\Console\Command;
use Tarik02\LaravelMixin\Contracts\Services\MixinCacheService;

/**
 * Class CacheClearCommand
 *
 * @package Tarik02\LaravelMixin\Console\Commands
 */
class CacheClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mixin:cache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear mixins cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->getLaravel()->make(MixinCacheService::class)->clearCache();
    }
}
