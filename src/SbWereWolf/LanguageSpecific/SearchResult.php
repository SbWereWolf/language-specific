<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 7:57 AM
 */

namespace SbWereWolf\LanguageSpecific;

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

    private null|int|string|bool|float $_key;
    private bool $_has;

    /**
     * SearchResult constructor.
     *
     * @param bool $success успех поиска
     * @param null|int|string|bool|float $key при успехе значение
     *                                          найденного ключа
     */
    public function __construct(
        bool $success = false,
        null|int|string|bool|float $key = null
    ) {
        $this->_key = $key;
        $this->_has = $success;
    }

    /**
     * Возвращает найденный ключ
     *
     * @return null|int|string|bool|float
     */
    public function key(): float|bool|int|string|null
    {
        return $this->_key;
    }

    /**
     * Возвращает флаг успешного результата поиска
     *
     * @return bool
     */
    public function has(): bool
    {
        return $this->_has;
    }
}
