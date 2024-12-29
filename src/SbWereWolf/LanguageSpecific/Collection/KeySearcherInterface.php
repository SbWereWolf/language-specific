<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 7:07 AM
 */

namespace SbWereWolf\LanguageSpecific\Collection;

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
     * @param string|int|float|bool|null $needle искомый индекс,
     * если не задан, то будет использован индекс текущего элемента
     *
     * @return SearchResultInterface
     */
    public function search(
        string|int|float|bool|null $needle = null
    ): SearchResultInterface;
}
