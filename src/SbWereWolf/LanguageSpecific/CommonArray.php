<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 5:11 AM
 */

namespace SbWereWolf\LanguageSpecific;


/**
 * Class CommonArray
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class CommonArray implements CommonArrayInterface
{
    /**
     * Массив с данными
     *
     * @var $_data array массив с которым работает класс
     */
    protected array $_data = [];
    protected CommonValueFactoryInterface $valueFactory;
    private bool $isDummy = true;

    public function __construct(
        mixed $data,
        CommonValueFactoryInterface|null $valueFactory = null,
    ) {
        $isProper = is_array($data);
        if (!$isProper) {
            $this->_data = [$data];
        }
        if ($isProper) {
            $this->_data = $data;
        }

        if (is_null($valueFactory)) {
            $this->valueFactory = new CommonValueFactory();
        }
        if ($valueFactory instanceof CommonValueFactoryInterface) {
            $this->valueFactory = $valueFactory;
        }
    }

    /* @inheritDoc */
    public function get(
        int|bool|string|null|float $key = null
    ): CommonValueInterface {
        $value = $this->valueFactory->makeCommonValueAsDummy();
        $payload = (new KeySearcher($this->_data))->search($key);
        if ($payload->has()) {
            $key = $payload->key();
            $value = $this->valueFactory->makeCommonValue(
                $this->_data[$key]
            );
        }

        return $value;
    }

    /* @inheritDoc */
    public function has(int|bool|string|null|float $key = null): bool
    {
        $output = (new KeySearcher($this->_data))->search($key);
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = $output->has();

        return $result;
    }

    /* @inheritDoc */
    public function raw(): array
    {
        return $this->_data;
    }

    /* @inheritDoc */
    public function isDummy(): bool
    {
        return $this->isDummy === true;
    }

    /**
     * Установить флаг "Является заглушкой"
     *
     * @return static
     */
    protected function riseIsDummy(): static
    {
        $this->isDummy = true;

        return $this;
    }

    /**
     * Сбросить флаг "Является заглушкой"
     *
     * @return static
     */
    protected function dropIsDummy(): static
    {
        $this->isDummy = false;

        return $this;
    }

    /* @inheritDoc */
    public function rewind(): void
    {
        reset($this->_data);
    }

    /* @inheritDoc */
    public function current(): CommonValueInterface
    {
        return $this->valueFactory::makeCommonValue($this->_data);
    }

    /* @inheritDoc */
    public function key(): int|bool|string|null|float
    {
        return key($this->_data);
    }

    /* @inheritDoc */
    public function next(): void
    {
        next($this->_data);
    }

    /* @inheritDoc */
    public function valid(): bool
    {
        return key_exists(key($this->_data), $this->_data);
    }

    /* @inheritDoc */
    public function jsonSerialize(): array
    {
        return $this->raw();
    }

    /* @inheritDoc */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /* @inheritDoc */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset)->asIs();
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
