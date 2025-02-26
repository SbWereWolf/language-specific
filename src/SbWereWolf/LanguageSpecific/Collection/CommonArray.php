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
        string|int|float|bool|null $key = null
    ): CommonValueInterface {
        $value = $this->valueFactory::makeCommonValueAsDummy();
        $payload = (new KeySearcher($this->data))->seek($key);
        if ($payload->has()) {
            $key = $payload->key();
            $value = $this->valueFactory::makeCommonValue(
                $this->data[$key]
            );
        }

        return $value;
    }

    /** @inheritDoc */
    public function has(string|int|float|bool|null $key = null): bool
    {
        $output = (new KeySearcher($this->data))->seek($key);
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = $output->has();

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
