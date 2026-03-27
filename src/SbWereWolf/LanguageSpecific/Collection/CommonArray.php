<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 3/27/26, 8:18 PM
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
        $has = $this->has($key);
        if (!$has) {
            $value = $this->valueFactory::makeCommonValueAsDummy();
        }
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
        $has = $this->hasAny();
        if (!$has) {
            $value = $this->valueFactory::makeCommonValueAsDummy();
        }
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
