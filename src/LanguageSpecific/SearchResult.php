<?php
/**
 * PHP version 5.6
 *
 * @category Library
 * @package  LanguageSpecific5.6
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 10.11.19 2:16
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
