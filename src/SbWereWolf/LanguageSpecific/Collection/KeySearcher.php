<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2025 Volkhin Nikolay
 * 1/12/25, 5:10 AM
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
        $needleInArray = in_array($needle, array_keys($data), true);
        if ($needleInArray) {
            $result = new SearchResult(true, $needle);
        }
        $isNeedleNull = false;
        if (!$needleInArray) {
            $isNeedleNull = is_null($needle);
        }
        $key = null;
        if ($isNeedleNull) {
            $key = key($data);
        }
        if (!is_null($key)) {
            $result = new SearchResult(true, $key);
        }

        return $result;
    }
}
