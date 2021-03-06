<?php
/**
 * PHP version 7.2
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 14.11.19 23:44
 */

namespace LanguageSpecific;

/**
 * Interface IKeySearcher
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface IKeySearcher
{
    /**
     * Искать заданный индекс
     *
     * @param null|int|string|bool|float $key искомый индекс, если
     *                                        не задан, то будет
     *                                        использован индекс
     *                                        текущего элемента
     *
     * @return ISearchResult
     */
    public function search($key = null): ISearchResult;
}
