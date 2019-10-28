<?php
/**
 * PHP version 5.6
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 29.10.2019, 2:58
 */

namespace LanguageSpecific;

/**
 * Class KeySearcher
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class KeySearcher implements IKeySearcher
{
    /**
     * Источник данных для поиска
     *
     * @var array
     */
    private $_source = [];

    /**
     * KeySearcher constructor.
     *
     * @param array $data массив для поиска индекса
     *
     * @return void
     */
    public function __construct(array &$data)
    {
        $this->_source = $data;
    }

    /**
     * Искать заданный индекс
     *
     * @param null $key искомый индекс, если не задан,
     *                  то будет использован индекс текущего элемента
     *
     * @return ISearchResult
     */
    public function search($key = null): ISearchResult
    {
        $result = new SearchResult(false, $key);

        $data = $this->_source;
        $keyExists = array_key_exists($key, $data);
        if ($keyExists) {
            $result = new SearchResult(true, $key);
        }
        $isNullValue = false;
        if (!$keyExists) {
            $isNullValue = is_null($key);
        }
        if ($isNullValue) {
            $key = key($data);
        }
        if ($isNullValue && !$keyExists) {
            $keyExists = array_key_exists($key, $data);
        }
        if ($isNullValue && $keyExists) {
            $result = new SearchResult(true, $key);
        }

        return $result;
    }
}
