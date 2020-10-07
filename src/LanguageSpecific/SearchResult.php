<?php
/**
 * PHP version 7.2
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 14.11.19 23:44
 */

namespace LanguageSpecific;

/**
 * Class SearchResult
 * Data Transfer Object
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class SearchResult implements ISearchResult
{

    private $_key = null;
    private $_has = false;

    /**
     * SearchResult constructor.
     *
     * @param $success bool  успех поиска
     * @param $key     mixed при успехе значение найденного ключа
     */
    public function __construct($success, $key)
    {
        $this->_key = $key;
        $this->_has = $success;
    }

    /**
     * Возвращает найденный ключ
     *
     * @return null|int|string|bool|float
     */
    public function key()
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
