<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:03 AM
 */

namespace SbWereWolf\LanguageSpecific\Array;

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
