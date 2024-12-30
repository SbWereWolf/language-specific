<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:35 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Collection;

/**
 * Class KeySearcher
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
class KeySearcher implements KeySearcherInterface
{
    /**
     * Источник данных для поиска
     *
     * @var array
     */
    private array $haystack;

    /**
     * KeySearcher constructor.
     *
     * @param array $data массив для поиска индекса
     *
     * @return       void
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public function __construct(array &$data)
    {
        $this->haystack = $data;
    }

    /** @inheritDoc */
    public function seek(
        string|int|float|bool|null $needle = null
    ): SearchResultInterface {
        $result = new SearchResult(false, $needle);

        $data = $this->haystack;
        $keyExists = in_array($needle, array_keys($data), true);
        if ($keyExists) {
            $result = new SearchResult(true, $needle);
        }
        $isNullKey = false;
        if (!$keyExists) {
            $isNullKey = is_null($needle);
        }
        if ($isNullKey) {
            $needle = key($data);
        }
        if ($isNullKey && !$keyExists) {
            $keyExists = in_array($needle, array_keys($data), true);
        }
        if ($isNullKey && $keyExists) {
            $result = new SearchResult(true, $needle);
        }

        return $result;
    }
}
