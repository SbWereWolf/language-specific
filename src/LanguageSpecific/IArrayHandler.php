<?php
/**
 * PHP version 5.6
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 31.10.2019, 3:37
 */

namespace LanguageSpecific;

use Generator;

/**
 * Interface IArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT
 *           https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface IArrayHandler
{

    /**
     * Получить элемент массива
     *
     * @param $key mixed индекс элемента
     *
     * @return IValueHandler
     */
    public function get($key = null): IValueHandler;

    /**
     * Если элемент массива является массивом, то
     * элементу присваивает значение первого элемента вложенного массива
     *
     * @return self
     */
    public function simplify(): self;

    /**
     * Извлекает следующий элемент массива
     * Значение будет экземпляром класса LanguageSpecific\ValueHandler
     *
     * @return Generator
     */
    public function next();

    /**
     * Проверяет имеет ли массив заданных индекс
     *
     * @param $key mixed индекс искомого элемента
     *
     * @return bool
     */
    public function has($key = null): bool;

    /**
     * Возвращает хэндлер для вложенного массива
     *
     * @param $key mixed индекс элемента с вложенным массивом
     *
     * @return self
     */
    public function pull($key = null): self;

    /**
     * возвращает флаг "Массив не задан"
     *
     * @return bool
     */
    public function isUndefined(): bool;
}
