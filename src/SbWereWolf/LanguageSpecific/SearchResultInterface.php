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
 * Interface SearchResultInterface
 * Data Transfer Object
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface SearchResultInterface
{
    /**
     * Возвращает найденный ключ
     *
     * @return null|int|string|bool|float
     */
    public function key(): null|int|string|bool|float;

    /**
     * Возвращает флаг успешного результата поиска
     *
     * @return bool
     */
    public function has(): bool;
}
