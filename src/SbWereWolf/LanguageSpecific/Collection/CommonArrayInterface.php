<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:35 AM
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
 */
interface CommonArrayInterface extends ArrayAccess
{
    /**
     * Проверяет, что массив имеет элемент с заданным индексом
     *
     * @param string|int|float|bool|null $key индекс искомого элемента
     *
     * @return bool
     */
    public function has(string|int|float|bool|null $key = null): bool;

    /**
     * По индексу получить элемент массива.
     * Возвращает экземпляр с интерфейсом CommonValueInterface
     *
     * @param string|int|float|bool|null $key индекс элемента
     *
     * @return CommonValueInterface
     */
    public function get(
        string|int|float|bool|null $key = null
    ): CommonValueInterface;
}
