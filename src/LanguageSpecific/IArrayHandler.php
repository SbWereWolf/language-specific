<?php
/**
 * PHP version 5.6
 *
 * @category Test
 * @package  LanguageSpecific5.6
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 10.11.19 2:16
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
    public function get($key = null);

    /**
     * Если элемент массива является массивом, то
     * элементу присваивает значение первого элемента вложенного массива
     *
     * @return self
     */
    public function simplify(array $needful = []);

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
    public function has($key = null);

    /**
     * Возвращает хэндлер для вложенного массива
     *
     * @param $key mixed индекс элемента с вложенным массивом
     *
     * @return self
     */
    public function pull($key = null);

    /**
     * возвращает флаг "Массив не задан"
     *
     * @return bool
     */
    public function isUndefined();
}
