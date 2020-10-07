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
    private $_source;

    /**
     * KeySearcher constructor.
     *
     * @param array $data массив для поиска индекса
     *
     * @return void
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
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
     * @return SearchResult
     */
    public function search($key = null)
    {
        $result = new SearchResult(false, $key);

        $data = $this->_source;
        $keyExists = array_key_exists($key, $data);
        if ($keyExists) {
            $result = new SearchResult(true, $key);
        }
        $isNullKey = false;
        if (!$keyExists) {
            $isNullKey = is_null($key);
        }
        if ($isNullKey) {
            $key = key($data);
        }
        if ($isNullKey && !$keyExists) {
            $keyExists = array_key_exists($key, $data);
        }
        if ($isNullKey && $keyExists) {
            $result = new SearchResult(true, $key);
        }

        return $result;
    }
}
