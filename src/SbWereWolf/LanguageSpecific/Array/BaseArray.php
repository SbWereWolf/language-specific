<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:03 AM
 */

declare(strict_types=1);
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 6:09 AM
 */

namespace SbWereWolf\LanguageSpecific\Array;


use ReturnTypeWillChange;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactoryInterface;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Class CommonArray
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class BaseArray implements BaseArrayInterface
{
    public function __construct(
        protected array $data,
        protected readonly CommonValueFactoryInterface $valueFactory,
    ) {
    }

    /* @inheritDoc */
    public function jsonSerialize(): array
    {
        return $this->raw();
    }

    /* @inheritDoc */
    public function raw(): array
    {
        return $this->data;
    }

    /* @inheritDoc */
    public function rewind(): void
    {
        reset($this->data);
    }

    /* @inheritDoc */
    public function current(): CommonValueInterface
    {
        return $this->valueFactory::makeCommonValue(
            current($this->data)
        );
    }

    /* @inheritDoc */
    public function key(): int|bool|string|null|float
    {
        return key($this->data);
    }

    /* @inheritDoc */
    #[ReturnTypeWillChange]
    public function next()
    {
        return next($this->data);
    }

    /* @inheritDoc */
    public function valid(): bool
    {
        return key_exists(key($this->data), $this->data);
    }
}
