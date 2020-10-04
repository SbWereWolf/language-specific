<?php
/**
 * PHP version 7.2
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 30.11.19 21:13
 */

namespace LanguageSpecific;

use Generator;
use Iterator;

/**
 * Interface IArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface IArrayHandler extends Iterator
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
     * Извлекает следующее значение, кроме массивов
     *
     * @return Generator
     */
    public function getting();

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
    public function pull($key = null): IArrayHandler;

    /**
     * Извлекает следующий массив
     * Значение будет экземпляром интерфейса IArrayHandler
     *
     * @return Generator
     */
    public function pulling();

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
