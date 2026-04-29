<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/29/26, 9:17 PM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Collection;

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
     * @var array<array-key, mixed>
     */
    protected $data;
    /** @var CommonValueFactoryInterface */
    protected $valueFactory;

    /**
     * Конструктор класса BaseArray
     *
     * @param array<array-key, mixed> $data Массив с элементами
     * для выдачи значений
     * @param CommonValueFactoryInterface $valueFactory фабрика для
     *                                  экземпляров CommonValueInterface
     */
    public function __construct(
        array $data,
        CommonValueFactoryInterface $valueFactory
    ) {
        $this->data = $data;
        $this->valueFactory = $valueFactory;
    }

    /** @inheritDoc */
    public function jsonSerialize(): array
    {
        return $this->raw();
    }

    /** @inheritDoc */
    /** @return array<array-key, mixed> */
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
        if (key($this->data) === null) {
            return $this->valueFactory::makeCommonValueAsDummy();
        }

        return $this->valueFactory::makeCommonValue(current($this->data));
    }

    /**
     * @inheritDoc
     *
     * @return int|string|null
     */
    public function key()
    {
        return key($this->data);
    }

    /** @inheritDoc */
    public function next(): void
    {
        next($this->data);
    }

    /** @inheritDoc */
    public function valid(): bool
    {
        return key($this->data) !== null;
    }
}
