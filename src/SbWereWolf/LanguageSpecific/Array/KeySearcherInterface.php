<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:58 AM
 */

namespace SbWereWolf\LanguageSpecific\Array;

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
     * @param string|int|float|bool|null $key искомый индекс,
     * если не задан, то будет использован индекс текущего элемента
     *
     * @return SearchResultInterface
     */
    public function search(
        string|int|float|bool|null $key = null
    ): SearchResultInterface;
}
