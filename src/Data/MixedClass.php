<?php

namespace Tarik02\LaravelMixin\Data;

use Tarik02\LaravelMixin\Contracts\Data\MixedClass as MixedClassContract;

/**
 * Class MixedClass
 *
 * @package Tarik02\LaravelMixin\Data
 */
class MixedClass implements MixedClassContract
{
    /** @var string */
    private $name;

    /** @var string|null */
    private $base;

    /** @var string[] */
    private $interfaces = [];

    /** @var string[] */
    private $traits = [];

    /** @var array[] */
    private $traitsResolutions = [];

    /** @var string[] */
    private $beforeConstruct = [];

    /** @var string[] */
    private $afterConstruct = [];

    /** @var string[] */
    private $code = [];

    /**
     * RegisteredClass constructor.
     *
     * @param string $name
     * @param string|null $base
     */
    public function __construct(string $name, ?string $base = null)
    {
        $this->name = $name;
        $this->base = $base;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getNamespace(): string
    {
        return \Str::beforeLast($this->name, '\\');
    }

    /**
     * @inheritDoc
     */
    public function getShortName(): string
    {
        return \Str::afterLast($this->name, '\\');
    }

    /**
     * @inheritDoc
     */
    public function getBaseClass(): ?string
    {
        return $this->base;
    }

    /**
     * @inheritDoc
     */
    public function getMixedInterfaces(): array
    {
        return $this->interfaces;
    }

    /**
     * @inheritDoc
     */
    public function getMixedTraits(): array
    {
        return $this->traits;
    }

    /**
     * @inheritDoc
     */
    public function getTraitsResolutions(): array
    {
        return $this->traitsResolutions;
    }

    /**
     * @inheritDoc
     */
    public function getCodeBeforeConstruct(): array
    {
        return $this->beforeConstruct;
    }

    /**
     * @inheritDoc
     */
    public function getCodeAfterConstruct(): array
    {
        return $this->afterConstruct;
    }

    /**
     * @inheritDoc
     */
    public function getClassCode(): array
    {
        return $this->code;
    }

    /**
     * @inheritDoc
     */
    public function mixInterface(string $name): MixedClassContract
    {
        $this->interfaces[$name] = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mixTrait(string $name, bool $hasConstructor = false): MixedClassContract
    {
        $this->traits[$name] = $name;

        if ($hasConstructor) {
            $slug = \Str::slug($name);

            $this->renameMethod($name, '__construct', "{$slug}__construct");
            $this->beforeConstruct("\$this->{$slug}__construct(...\$args);");
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function useInsteadOf(string $method, string $trait, string $replacedTrait): MixedClassContract
    {
        $type = 'insteadof';

        $this->traitsResolutions []= compact('type', 'method', 'trait', 'replacedTrait');

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function renameMethod(string $trait, string $oldName, string $newName): MixedClassContract
    {
        $type = 'as';

        $this->traitsResolutions []= compact('type', 'trait', 'oldName', 'newName');

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function beforeConstruct(string $code): MixedClassContract
    {
        if ($code[strlen($code) - 1] !== ';') {
            $code .= ';';
        }

        $this->beforeConstruct []= $code;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function afterConstruct(string $code): MixedClassContract
    {
        if ($code[strlen($code) - 1] !== ';') {
            $code .= ';';
        }

        $this->afterConstruct []= $code;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function code(string $code): MixedClassContract
    {
        $this->code []= $code;

        return $this;
    }
}
