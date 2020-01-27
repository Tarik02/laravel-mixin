<?php

namespace Tarik02\LaravelMixin\Contracts\Services;

/**
 * Interface CustomClassLoader
 *
 * @package Tarik02\LaravelMixin\Contracts\Services
 */
interface CustomClassLoader
{
    /**
     * @return void
     */
    public function register(): void;

    /**
     * @param string $name
     * @return void
     */
    public function loadClass(string $name): void;
}
