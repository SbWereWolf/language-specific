<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2025 Volkhin Nikolay
 * 1/12/25, 5:02 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Collection;

use JetBrains\PhpStorm\Pure;
use ReturnTypeWillChange;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactoryInterface;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Class BaseArray
 *
 * @category Library
 * @package  LanguageSpecificc
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
class BaseArray implements BaseArrayInterface
{
    /**
     * Конструктор класса BaseArray
     *
     * @param array $data Массив с элементами для выдачи значений
     * @param CommonValueFactoryInterface $valueFactory фабрика для
     *                                  экземпляров CommonValueInterface
     */
    public function __construct(
        protected array $data,
        protected readonly CommonValueFactoryInterface $valueFactory,
    ) {
    }

    /** @inheritDoc */
    #[Pure]
    public function jsonSerialize(): array
    {
        return $this->raw();
    }

    /** @inheritDoc */
    public function raw(): array
    {
        return $this->data;
    }

    /** @inheritDoc */
    public function rewind(): void
    {
        reset($this->data);
    }

    /** @inheritDoc */
    public function current(): CommonValueInterface
    {
        return $this->valueFactory::makeCommonValue(
            current($this->data)
        );
    }

    /** @inheritDoc */
    public function key(): int|bool|string|null|float
    {
        return key($this->data);
    }

    /** @inheritDoc */
    #[ReturnTypeWillChange]
    public function next()
    {
        return next($this->data);
    }

    /** @inheritDoc */
    public function valid(): bool
    {
        $key = key($this->data);
        $isValid = !is_null($key);

        return $isValid;
    }
}
