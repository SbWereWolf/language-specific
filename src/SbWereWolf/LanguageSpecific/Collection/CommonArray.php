<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2025 Volkhin Nikolay
 * 2/27/25, 12:34 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Collection;

use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Class CommonArray
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
class CommonArray extends BaseArray implements CommonArrayInterface
{
    /** @inheritDoc */
    public function get(
        string|int|float|bool|null $key
    ): CommonValueInterface {
        $value = $this->valueFactory::makeCommonValueAsDummy();
        $key = $this->normalizeKey($key);
        $has = $this->has($key);
        if ($has) {
            $value = $this->valueFactory::makeCommonValue(
                $this->data[$key]
            );
        }

        return $value;
    }

    /** @inheritDoc */
    public function getAny(): CommonValueInterface
    {
        $value = $this->valueFactory::makeCommonValueAsDummy();
        $has = $this->hasAny();
        if ($has) {
            $first = array_key_first($this->data);
            $value = $this->valueFactory::makeCommonValue(
                $this->data[$first]
            );
        }

        return $value;
    }

    /** @inheritDoc */
    public function has(string|int|float|bool|null $key): bool
    {
        $key = $this->normalizeKey($key);
        $result = array_key_exists($key, $this->data);

        return $result;
    }

    public function hasAny(): bool
    {
        $result = count($this->data) > 0;

        return $result;
    }

    /** @inheritDoc */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /** @inheritDoc */
    public function offsetGet($offset): CommonValueInterface
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     *
     * @throws ValueIsImmutableException
     */
    /** @phan-suppress-next-line PhanUnusedPublicMethodParameter */
    public function offsetSet($_offset, $_value): void
    {
        throw new ValueIsImmutableException(
            'Value of element is immutable.',
            -1
        );
    }

    /**
     * @inheritDoc
     *
     * @throws ListIsImmutableException
     */
    /** @phan-suppress-next-line PhanUnusedPublicMethodParameter */
    public function offsetUnset($_offset): void
    {
        throw new ListIsImmutableException(
            'List of elements is immutable.',
            -2
        );
    }

    /**
     * Нормализует тип ключа до допустимого array-key.
     *
     * @param string|int|float|bool|null $key
     *
     * @return int|string
     */
    private function normalizeKey(
        string|int|float|bool|null $key
    ): int|string {
        if (is_null($key)) {
            return '';
        }

        if (is_bool($key) || is_float($key)) {
            return (int)$key;
        }

        return $key;
    }
}
