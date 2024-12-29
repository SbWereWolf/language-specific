<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 7:07 AM
 */

declare(strict_types=1);
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 5:56 AM
 */

namespace SbWereWolf\LanguageSpecific\Collection;

/**
 * Class SearchResult
 * Data Transfer Object
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class SearchResult implements SearchResultInterface
{
    /**
     * SearchResult constructor.
     *
     * @param bool $has флаг успех поиска, массив имеет заданный индекс?
     * @param string|int|float|bool|null $key при успехе значение
     *                                          найденного ключа
     */
    public function __construct(
        private readonly bool $has = false,
        private readonly string|int|float|bool|null $key = null
    ) {
    }

    /**
     * Возвращает найденный ключ
     *
     * @return string|int|float|bool|null
     */
    public function key(): string|int|float|bool|null
    {
        return $this->key;
    }

    /**
     * Возвращает флаг успешного результата поиска
     *
     * @return bool
     */
    public function has(): bool
    {
        return $this->has;
    }
}
