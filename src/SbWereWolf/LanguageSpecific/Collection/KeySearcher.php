<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 6:24 AM
 */

declare(strict_types=1);
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 5:55 AM
 */

namespace SbWereWolf\LanguageSpecific\Collection;


/**
 * Class KeySearcher
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class KeySearcher implements KeySearcherInterface
{
    /**
     * Источник данных для поиска
     *
     * @var array
     */
    private array $_source;

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
     * @param string|int|float|bool|null $key искомый индекс,
     * если не задан, то будет использован индекс текущего элемента
     *
     * @return SearchResultInterface
     */
    public function search(
        string|int|float|bool|null $key = null
    ): SearchResultInterface {
        $result = new SearchResult(false, $key);

        $data = $this->_source;
        $keyExists = in_array($key, array_keys($data), true);
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
            $keyExists = in_array($key, array_keys($data), true);
        }
        if ($isNullKey && $keyExists) {
            $result = new SearchResult(true, $key);
        }

        return $result;
    }
}
