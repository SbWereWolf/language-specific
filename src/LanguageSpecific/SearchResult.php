<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2020 Volkhin Nikolay
 * 08.10.2020, 3:48
 */

/**
 * PHP version 5.6
 *
 * @category Library
 */

namespace LanguageSpecific;

/**
 * Class SearchResult
 * Data Transfer Object
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class SearchResult implements ISearchResult
{

    private $_key;
    private $_has;

    /**
     * SearchResult constructor.
     *
     * @param $success bool  успех поиска
     * @param $key     mixed при успехе значение найденного ключа
     */
    public function __construct($success = false, $key = null)
    {
        $this->_key = $key;
        $this->_has = $success;
    }

    /**
     * Возвращает найденный ключ
     *
     * @return mixed
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
    public function has()
    {
        return $this->_has;
    }
}
