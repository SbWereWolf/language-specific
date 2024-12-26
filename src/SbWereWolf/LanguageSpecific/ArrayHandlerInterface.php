<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 7:57 AM
 */

namespace SbWereWolf\LanguageSpecific;

use ArrayAccess;
use Generator;
use Iterator;
use JsonSerializable;

/**
 * Interface IArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface ArrayHandlerInterface
    extends Iterator, JsonSerializable, ArrayAccess
{
    /**
     * Получить элемент массива
     *
     * @param $key int|bool|string|null|float индекс элемента
     *
     * @return ValueHandlerInterface
     */
    public function get(
        int|bool|string|null|float $key = null
    ): ValueHandlerInterface;

    /**
     * Извлекает следующее значение, кроме массивов
     *
     * @return Generator
     */
    public function getting(): Generator;

    /**
     * Проверяет имеет ли массив заданный индекс
     *
     * @param $key int|bool|string|null индекс искомого элемента
     *
     * @return bool
     */
    public function has(int|bool|string|null|float $key = null): bool;

    /**
     * Возвращает ArrayHandlerInterface для вложенного массива
     *
     * @param $key int|bool|string|null|float индекс элемента с массивом
     *
     * @return ArrayHandlerInterface
     */
    public function pull(
        int|bool|string|null|float $key = null
    ): ArrayHandlerInterface;

    /**
     * Извлекает следующий массив
     * Значение будет экземпляром интерфейса ArrayHandlerInterface
     *
     * @return Generator
     */
    public function pulling(): Generator;

    /**
     * Возвращает флаг "Массив не был задан"
     *
     * @return bool
     */
    public function wasNotDefined(): bool;

    /**
     * Возвращает исходный массив
     *
     * @return array
     */
    public function raw(): array;
}
