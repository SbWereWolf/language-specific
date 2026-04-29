<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/29/26, 8:46 PM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Collection;

use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactoryInterface;

/**
 * Class ArrayFactory
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayFactory implements ArrayFactoryInterface
{
    protected CommonValueFactoryInterface $valueFactory;

    /**
     * Конструктор класса ArrayFactory
     *
     * @param CommonValueFactoryInterface|null $factory фабрика для
     *                                  экземпляров CommonValueInterface
     */
    public function __construct(
        ?CommonValueFactoryInterface $factory = null
    ) {
        if (is_null($factory)) {
            $factory = new CommonValueFactory();
        }

        $this->valueFactory = $factory;
    }

    /** @inheritDoc */
    public function makeBaseArray($data): BaseArrayInterface
    {
        $data = $this->makeItProper($data);

        return new BaseArray($data, $this->valueFactory);
    }

    /**
     * Делает из переменной массив, если её тип не массив
     *
     * @param mixed $data
     *
     * @return array<array-key, mixed>
     */
    protected function makeItProper($data): array
    {
        return is_array($data) ? $data : [$data];
    }

    /** @inheritDoc */
    public function makeCommonArray($data): CommonArrayInterface
    {
        $data = $this->makeItProper($data);

        return new CommonArray($data, $this->valueFactory);
    }
}
