<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:03 AM
 */

namespace SbWereWolf\LanguageSpecific\Array;

use ArrayAccess;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Interface CommonArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface CommonArrayInterface extends ArrayAccess
{
    /**
     * Проверяет, что массив имеет элемент с заданным индексом
     *
     * @param int|bool|string|null|float $key индекс искомого элемента
     *
     * @return bool
     */
    public function has(int|bool|string|null|float $key = null): bool;

    /**
     * По индексу получить элемент массива.
     * Возвращает экземпляр с интерфейсом CommonValueInterface
     *
     * @param int|bool|string|null|float $key индекс элемента
     *
     * @return CommonValueInterface
     */
    public function get(
        int|bool|string|null|float $key = null
    ): CommonValueInterface;
}
