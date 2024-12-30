<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:35 AM
 */

namespace SbWereWolf\LanguageSpecific\Collection;

/**
 * Interface KeySearcherInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
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
    public function seek(
        string|int|float|bool|null $needle = null
    ): SearchResultInterface;
}
