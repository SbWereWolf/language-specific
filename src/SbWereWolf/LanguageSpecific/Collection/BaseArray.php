<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
 */


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
    public function jsonSerialize()
    {
        return $this->raw();
    }

    /** @inheritDoc */
    /** @return array<array-key, mixed> */
    public function raw()
    {
        return $this->data;
    }

    /** @inheritDoc */
    public function rewind()
    {
        reset($this->data);
    }

    /** @inheritDoc */
    public function current()
    {
        $valueFactory = get_class($this->valueFactory);

        if (key($this->data) === null) {
            return $valueFactory::makeCommonValueAsDummy();
        }

        return $valueFactory::makeCommonValue(current($this->data));
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
    public function next()
    {
        next($this->data);
    }

    /** @inheritDoc */
    public function valid()
    {
        return key($this->data) !== null;
    }
}
