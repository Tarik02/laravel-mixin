<?php

namespace Tarik02\LaravelMixin\Contracts\Data;

/**
 * Interface MixedClass
 *
 * @package Tarik02\LaravelMixin\Contracts\Data
 */
interface MixedClass
{
    /**
     * Returns the FQN (fully-qualified name) of the generated class (mixin).
     *
     * @return string
     *
     * @see self::getNamespace()
     * @see self::getShortName()
     */
    public function getName(): string;

    /**
     * Returns the namespace of the generated class (mixin).
     *
     * @return string
     *
     * @see self::getName()
     * @see self::getShortName()
     */
    public function getNamespace(): string;

    /**
     * Returns the short name (without namespace) of the generated class (mixin).
     *
     * @return string
     *
     * @see self::getName()
     * @see self::getNamespace()
     */
    public function getShortName(): string;

    /**
     * Returns the FQN (fully-qualified name) of base class.
     *
     * @return string|null
     */
    public function getBaseClass(): ?string;

    /**
     * Returns the list of mixed interfaces (mixed class implements all of them).
     *
     * @return string[]
     *
     * @see self::mixInterface()
     */
    public function getMixedInterfaces(): array;

    /**
     * Returns the list of mixed traits (mixed class uses all of them).
     *
     * @return string[]
     *
     * @see self::getTraitsResolutions()
     * @see self::mixTrait()
     */
    public function getMixedTraits(): array;

    /**
     * Returns the list of traits resolutions (`insteadof`, `as` in use statement).
     *
     * Here's how the array item should like:
     *
     * ```php
     *     [
     *         'type' => 'insteadof',
     *         'method' => '',        // method name
     *         'trait' => '',         // FQN of trait which contains the new method
     *         'replacedTrait' => '', // FQN of trait whose method is being replaced
     *     ]
     *     [
     *         'type' => 'as',
     *         'trait' => '',   // FQN of trait whose method will be renamed
     *         'oldName' => '', // the old name of the method
     *         'newName' => '', // the new name of the method
     *     ]
     * ```
     *
     * @return array[]
     *
     * @see self::getMixedTraits()
     * @see self::useInsteadOf()
     * @see self::renameMethod()
     */
    public function getTraitsResolutions(): array;

    /**
     * Returns an array of code which should be injected before parent constructor call.
     *
     * @return string[]
     *
     * @see beforeConstruct()
     */
    public function getCodeBeforeConstruct(): array;

    /**
     * Returns an array of code which should be injected after parent constructor call.
     *
     * @return string[]
     *
     * @see self::afterConstruct()
     */
    public function getCodeAfterConstruct(): array;

    /**
     * Returns an array of code which should be injected into class body.
     *
     * @return string[]
     *
     * @see self::code()
     */
    public function getClassCode(): array;

    /**
     * Adds an interface to the list of implemented interfaces.
     *
     * @param string $name FQN (fully-qualified name) of the interface (normally taken with MyInterface::class).
     * @return $this
     *
     * @see self::getMixedInterfaces()
     */
    public function mixInterface(string $name): self;

    /**
     * Adds a trait to the list of implemented interfaces.
     *
     * @param string $name         FQN (fully-qualified name) of the trait (normally taken with MyInterface::class).
     * @param bool $hasConstructor Default: false. If true, then the trait's constructor will be called before parent class constructor.
     * @return $this
     *
     * @see self::getMixedTraits()
     * @see self::useInsteadOf()
     * @see self::renameMethod()
     * @see self::beforeConstruct()
     * @see self::afterConstruct()
     */
    public function mixTrait(string $name, bool $hasConstructor = false): self;

    /**
     * Adds a trait resolution looking like:
     *
     * ```php
     *     "\{$trait}::{$method} insteadof \{$replacedTrait};"
     * ```
     *
     * @param string $method        Method name.
     * @param string $trait         Trait whose method is going to be used.
     * @param string $replacedTrait Trait whose method is going to be replaced.
     * @return $this
     *
     * @see self::getTraitsResolutions()
     * @see self::mixTrait()
     * @see self::renameMethod()
     */
    public function useInsteadOf(string $method, string $trait, string $replacedTrait): self;

    /**
     * Adds a trait resolution looking like:
     *
     * ```php
     *     "\{$trait}::{$oldName} as {$newName};"
     * ```
     *
     * @param string $trait   Trait, whose method is going to be renamed.
     * @param string $oldName The old method name.
     * @param string $newName The new method name.
     * @return $this
     *
     * @see self::getTraitsResolutions()
     * @see self::mixTrait()
     * @see self::useInsteadOf()
     */
    public function renameMethod(string $trait, string $oldName, string $newName): self;

    /**
     * Adds the code before
     *
     * ```php
     *     parent::__construct(...$args)
     * ```
     *
     * call. You can omit ';' at the end of code.
     *
     * @param string $code The code being added.
     * @return $this
     *
     * @see self::getCodeBeforeConstruct()
     * @see self::afterConstruct()
     */
    public function beforeConstruct(string $code): self;

    /**
     * Adds the code after
     *
     * ```php
     *     parent::__construct(...$args)
     * ```
     *
     * call. You can omit ';' at the end of code.
     *
     * @param string $code The code being added.
     * @return $this
     *
     * @see getCodeAfterConstruct()
     * @see beforeConstruct()
     */
    public function afterConstruct(string $code): self;

    /**
     * Adds the code into the class body. Should be used only for methods/properties declaration.
     *
     * @param string $code The code being added.
     * @return $this
     *
     * @see self::getClassCode()
     */
    public function code(string $code): self;
}
