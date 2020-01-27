<?php

namespace Tarik02\LaravelMixin\Console\Commands;

use Illuminate\Console\Command;
use Tarik02\LaravelMixin\Contracts\Services\MixinGeneratorService;

/**
 * Class GenerateCommand
 *
 * @package Tarik02\LaravelMixin\Console\Commands
 */
class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mixin:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all mixins';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->getLaravel()->make(MixinGeneratorService::class)->generateAllClasses();
    }
}
