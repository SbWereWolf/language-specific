<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 9:40 PM
 */

namespace SbWereWolf\LanguageSpecific;

use ArrayAccess;
use Iterator;
use JsonSerializable;

/**
 * Interface CommonArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface CommonArrayInterface
    extends Iterator, JsonSerializable, ArrayAccess
{
    /**
     * Возвращает флаг "является заглушкой"
     *
     * @return bool
     */
    public function isDummy(): bool;

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

    /**
     * Возвращает исходный массив без обработки
     *
     * @return array
     */
    public function raw(): array;
}
