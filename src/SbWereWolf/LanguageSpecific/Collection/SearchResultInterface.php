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
 * Interface SearchResultInterface
 * Data Transfer Object
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface SearchResultInterface
{
    /**
     * Возвращает найденный ключ
     *
     * @return string|int|float|bool|null
     */
    public function key(): string|int|float|bool|null;

    /**
     * Возвращает флаг успешного результата поиска
     *
     * @return bool
     */
    public function has(): bool;
}
