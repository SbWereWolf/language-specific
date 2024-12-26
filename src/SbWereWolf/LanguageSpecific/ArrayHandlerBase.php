<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 8:33 AM
 */

namespace SbWereWolf\LanguageSpecific;


use Iterator;
use JsonSerializable;

/**
 * Class ArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandlerBase implements Iterator, JsonSerializable
{
    /**
     * Массив с данными
     *
     * @var $_data array массив с которым работает класс
     */
    protected array $_data = [];
    protected ValueHandlerFactoryInterface $valueFactory;
    private bool $isDummy = true;

    public function __construct(
        array $data,
        ValueHandlerFactoryInterface|null $valueFactory = null,
    ) {
        $this->_data = $data;

        if (is_null($valueFactory)) {
            $this->valueFactory = new ValueHandlerFactory();
        }
        if ($valueFactory instanceof ValueHandlerFactoryInterface) {
            $this->valueFactory = $valueFactory;
        }
    }

    /**
     * Возвращает флаг "Массив не задан"
     *
     * @return bool
     */
    public function isDummy(): bool
    {
        return $this->isDummy;
    }

    public function rewind(): void
    {
        reset($this->_data);
    }

    public function current(): ValueHandlerInterface
    {
        return $this->valueFactory::makeValueHandler($this->_data);
    }

    public function key(): int|bool|string|null|float
    {
        return key($this->_data);
    }

    public function next(): void
    {
        next($this->_data);
    }

    public function valid(): bool
    {
        return key_exists(key($this->_data), $this->_data);
    }

    public function jsonSerialize(): array
    {
        return $this->raw();
    }

    /**
     * Возвращает исходный массив
     *
     * @return array
     */
    public function raw(): array
    {
        return $this->_data;
    }

    /**
     * Установить значение незаданным
     *
     * @return static
     */
    protected function riseIsDummy(): static
    {
        $this->isDummy = true;

        return $this;
    }

    /**
     * Установить как не заданное
     *
     * @return static
     */
    protected function dropIsDummy(): static
    {
        $this->isDummy = false;

        return $this;
    }
}
