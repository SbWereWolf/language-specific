<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
 */


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
        $key
    ) {
        $valueFactory = get_class($this->valueFactory);

        if (!array_key_exists($key, $this->data)) {
            return $valueFactory::makeCommonValueAsDummy();
        }

        return $valueFactory::makeCommonValue($this->data[$key]);
    }

    /** @inheritDoc */
    public function getAny()
    {
        $valueFactory = get_class($this->valueFactory);
        $first = array_key_first($this->data);
        if ($first === null) {
            return $valueFactory::makeCommonValueAsDummy();
        }

        return $valueFactory::makeCommonValue($this->data[$first]);
    }

    /** @inheritDoc */
    public function has($key)
    {
        $result = array_key_exists($key, $this->data);

        return $result;
    }

    public function hasAny()
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
    private function isSupportedIndex($offset)
    {
        return is_int($offset)
            || is_string($offset)
            || is_float($offset)
            || is_bool($offset)
            || $offset === null;
    }

    /** @inheritDoc */
    public function offsetExists($offset)
    {
        if (!$this->isSupportedIndex($offset)) {
            return false;
        }

        return $this->has($offset);
    }

    /** @inheritDoc */
    public function offsetGet($offset)
    {
        if (!$this->isSupportedIndex($offset)) {
            $valueFactory = get_class($this->valueFactory);

            return $valueFactory::makeCommonValueAsDummy();
        }

        return $this->get($offset);
    }

    /**
     * @inheritDoc
     *
     * @throws ValueIsImmutableException
     */
    public function offsetSet($offset, $value)
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
    public function offsetUnset($offset)
    {
        throw new ListIsImmutableException(
            'List of elements is immutable.',
            -2
        );
    }
}
