<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 9:40 PM
 */

namespace SbWereWolf\LanguageSpecific;

/**
 * Interface KeySearcherInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface KeySearcherInterface
{
    /**
     * Искать заданный индекс
     *
     * @param null|int|string|bool|float $key искомый индекс,
     * если не задан, то будет использован индекс текущего элемента
     *
     * @return SearchResultInterface
     */
    public function search(
        null|int|string|bool|float $key = null
    ): SearchResultInterface;
}
