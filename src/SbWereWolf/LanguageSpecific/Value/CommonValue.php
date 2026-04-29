<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/29/26, 1:15 PM
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
final class CommonValue implements CommonValueInterface
{
    /**
     * Создать экземпляр с заданным значением
     *
     * @param mixed $value Произвольное значение
     * @param bool $isReal Значение является действительным
     */
    public function __construct(
        private mixed $value = null,
        private bool $isReal = true
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
        return $this->value;
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
        if ($this->isReal()) {
            return $this;
        }

        return new self($value, false);
    }

    public function class(): string
    {
        return get_debug_type($this->asIs());
    }
}
