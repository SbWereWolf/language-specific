<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 3/31/26, 3:31 AM
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
        if (!array_key_exists($key, $this->data)) {
            return $this->valueFactory::makeCommonValueAsDummy();
        }

        return $this->valueFactory::makeCommonValue($this->data[$key]);
    }

    /** @inheritDoc */
    public function getAny(): CommonValueInterface
    {
        $first = array_key_first($this->data);
        if ($first === null) {
            return $this->valueFactory::makeCommonValueAsDummy();
        }

        return $this->valueFactory::makeCommonValue($this->data[$first]);
    }

    /** @inheritDoc */
    public function has(string|int|float|bool|null $key): bool
    {
        $result = array_key_exists($key, $this->data);

        return $result;
    }

    public function hasAny(): bool
    {
        $result = count($this->data) > 0;

        return $result;
    }

    /**
     * Проверяет, что индекс допустим для ключа PHP-массива.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    private function isSupportedIndex(mixed $offset): bool
    {
        return is_int($offset)
            || is_string($offset)
            || is_float($offset)
            || is_bool($offset)
            || $offset === null;
    }

    /** @inheritDoc */
    public function offsetExists($offset): bool
    {
        if (!$this->isSupportedIndex($offset)) {
            return false;
        }

        return $this->has($offset);
    }

    /** @inheritDoc */
    public function offsetGet($offset): CommonValueInterface
    {
        if (!$this->isSupportedIndex($offset)) {
            return $this->valueFactory::makeCommonValueAsDummy();
        }

        return $this->get($offset);
    }

    /**
     * @inheritDoc
     *
     * @throws ValueIsImmutableException
     */
    public function offsetSet($offset, $value): void
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
    public function offsetUnset($offset): void
    {
        throw new ListIsImmutableException(
            'List of elements is immutable.',
            -2
        );
    }
}
