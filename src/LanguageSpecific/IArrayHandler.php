<?php
/**
 * PHP version 7.0
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 14.11.19 23:44
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
     * @param $key mixed индекс элемента
     *
     * @return IValueHandler
     */
    public function get($key = null): IValueHandler;

    /**
     * Если элемент массива является массивом, то
     * элементу присваивает значение первого элемента вложенного массива
     * Если задан аргумент $needful, то из вложеного массива берутся
     * все элменты с индексами из $needful[]
     *
     * @return self
     */
    public function simplify(array $needful = []): self;

    /**
     * Извлекает следующий элемент массива
     * Значение будет экземпляром класса LanguageSpecific\ValueHandler
     *
     * @return Generator
     */
    public function next();

    /**
     * Проверяет имеет ли массив заданный индекс
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
