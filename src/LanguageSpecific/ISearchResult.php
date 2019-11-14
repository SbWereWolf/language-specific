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

/**
 * Interface ISearchResult
 * Data Transfer Object
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
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
    public function has(): bool;
}
