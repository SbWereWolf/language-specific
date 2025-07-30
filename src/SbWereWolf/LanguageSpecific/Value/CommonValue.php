<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2025 Volkhin Nikolay
 * 7/30/25, 11:18 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Value;

/**
 * Class CommonValue
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
class CommonValue implements CommonValueInterface
{
    /**
     * Значение по умолчанию для неопределённого значения,
     * используется когда значение не задано
     *
     * @var mixed $default значение по умолчанию
     */
    private mixed $default = null;

    /**
     * Создать экземпляр с заданным значением
     *
     * @param mixed $value Произвольное значение
     * @param bool $isReal Значение является действительным
     */
    public function __construct(
        private readonly mixed $value = null,
        private readonly bool $isReal = true
    ) {
    }

    /** @inheritDoc */
    public function isReal(): bool
    {
        return $this->isReal === true;
    }

    /** @inheritDoc */
    public function asIs(): mixed
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = $this->isReal() ? $this->value : $this->default;

        return $result;
    }

    /** @inheritDoc */
    public function int(): int
    {
        return (int)($this->asIs());
    }

    /** @inheritDoc */
    public function str(): string
    {
        return (string)($this->asIs());
    }

    /** @inheritDoc */
    public function bool(): bool
    {
        return (bool)($this->asIs());
    }

    /** @inheritDoc */
    public function double(): float
    {
        return (float)($this->asIs());
    }

    /** @inheritDoc */
    public function array(): array
    {
        return (array)($this->asIs());
    }

    /** @inheritDoc */
    public function object(): object
    {
        return (object)($this->asIs());
    }

    /** @inheritDoc */
    public function type(): string
    {
        return gettype($this->asIs());
    }

    /** @inheritDoc */
    public function default(mixed $value = null): CommonValueInterface
    {
        $this->default = $value;

        return $this;
    }

    public function class(): string
    {
        return get_debug_type($this->asIs());
    }
}
