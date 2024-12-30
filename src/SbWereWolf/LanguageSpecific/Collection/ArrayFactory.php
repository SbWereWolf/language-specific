<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:35 AM
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
    protected readonly CommonValueFactoryInterface $valueFactory;

    /**
     * Конструктор класса ArrayFactory
     *
     * @param CommonValueFactoryInterface|null $factory фабрика для
     *                                  экземпляров CommonValueInterface
     */
    public function __construct(
        CommonValueFactoryInterface|null $factory = null
    ) {
        if (is_null($factory)) {
            $factory = new CommonValueFactory();
        }

        $this->valueFactory = $factory;
    }

    /** @inheritDoc */
    public function makeBaseArray(mixed $data): BaseArrayInterface
    {
        $data = $this->makeItProper($data);

        return new BaseArray($data, $this->valueFactory);
    }

    /**
     * Делает из переменной массив, если её тип не массив
     *
     * @param mixed $data
     *
     * @return array
     */
    protected function makeItProper(mixed $data): array
    {
        $isProper = is_array($data);
        if (!$isProper) {
            $data = [$data];
        }
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $data = array_replace([], $data);

        return $data;
    }

    /** @inheritDoc */
    public function makeCommonArray(mixed $data): CommonArrayInterface
    {
        $data = $this->makeItProper($data);

        return new CommonArray($data, $this->valueFactory);
    }
}
