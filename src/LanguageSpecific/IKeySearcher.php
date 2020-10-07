<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2020 Volkhin Nikolay
 * 08.10.2020, 3:45
 */

/**
 * PHP version 7.0
 *
 * @category Library
 */

namespace LanguageSpecific;

/**
 * Interface IKeySearcher
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
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
