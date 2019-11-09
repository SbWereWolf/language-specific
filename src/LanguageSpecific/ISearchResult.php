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

/**
 * Interface ISearchResult
 * Data Transfer Object
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT
 *           https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface ISearchResult
{
    /**
     * Возвращает найденный ключ
     *
     * @return null|int|string|bool|float
     */
    public function key();

    /**
     * Возвращает флаг успешного результата поиска
     *
     * @return bool
     */
    public function has();
}
