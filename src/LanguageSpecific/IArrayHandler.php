<?php
/**
 * PHP version 7.0
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 30.11.19 21:14
 */

namespace LanguageSpecific;

use Generator;

/**
 * Interface IArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface IArrayHandler
{
    /**
     * Получить элемент массива
     *
     * @param $key int|bool|string|null индекс элемента
     *
     * @return IValueHandler
     */
    public function get($key = null): IValueHandler;

    /**
     * Извлекает следующий массив
     * Значение будет экземпляром интерфейса IArrayHandler
     *
     * @return Generator
     */
    public function pulling();

    /**
     * Проверяет имеет ли массив заданный индекс
     *
     * @param $key int|bool|string|null индекс искомого элемента
     *
     * @return bool
     */
    public function has($key = null): bool;

    /**
     * Возвращает IArrayHandler для вложенного массива
     *
     * @param $key int|bool|string|null индекс элемента с массивом
     *
     * @return IArrayHandler
     */
    public function pull($key = null): self;

    /**
     * возвращает флаг "Массив не задан"
     *
     * @return bool
     */
    public function isUndefined(): bool;

    /**
     * Возвращает исходный массив
     *
     * @return array
     */
    public function raw(): array;
}
