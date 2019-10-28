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
 * 29.10.2019, 2:58
 */

namespace LanguageSpecific;

/**
 * Interface IKeySearcher
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT
 *           https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
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
