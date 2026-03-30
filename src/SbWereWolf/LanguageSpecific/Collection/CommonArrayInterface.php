<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 3/31/26, 2:52 AM
 */

namespace SbWereWolf\LanguageSpecific\Collection;

use ArrayAccess;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Interface CommonArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * @extends ArrayAccess<array-key, CommonValueInterface>
 */
interface CommonArrayInterface extends ArrayAccess, BaseArrayInterface
{
    /**
     * Проверяет, что массив имеет элемент с заданным индексом
     *
     * @param string|int|float|bool|null $key индекс искомого элемента
     *
     * @return bool
     */
    public function has(string|int|float|bool|null $key): bool;

    /**
     * Проверяет, что массив имеет хотя бы одно значение (не пустой)
     *
     * @return bool
     */
    public function hasAny(): bool;

    /**
     * По индексу получить элемент массива.
     * Возвращает экземпляр с интерфейсом CommonValueInterface
     *
     * @param string|int|float|bool|null $key индекс элемента
     *
     * @return CommonValueInterface
     */
    public function get(
        string|int|float|bool|null $key
    ): CommonValueInterface;

    /**
     * Получить хотя бы первый элемент массива.
     * Возвращает экземпляр с интерфейсом CommonValueInterface
     *
     * @return CommonValueInterface
     */
    public function getAny(): CommonValueInterface;
}
