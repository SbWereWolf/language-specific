<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 7:07 AM
 */

namespace SbWereWolf\LanguageSpecific\Value;


/**
 * Class CommonValue
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class CommonValue implements CommonValueInterface
{
    /**
     * Значение по умолчанию для неопределённого значения,
     * используется когда значение не задано
     *
     * @var mixed $default значение по умолчанию
     */
    private mixed $default = null;

    /**
     * Создать экземпляр с заданным значением
     *
     * @param mixed $value произвольное значение
     * @param bool $isReal Значение является действительным
     */
    public function __construct(
        private readonly mixed $value = null,
        private readonly bool $isReal = true
    ) {
    }

    /**
     * Возвращает флаг "Имеет значение"
     *
     * @return bool
     */
    public function isReal(): bool
    {
        return $this->isReal === true;
    }

    /**
     * Возвращает значение как оно есть
     *
     * @return mixed
     */
    public function asIs(): mixed
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = $this->isReal() ? $this->value : $this->default;

        return $result;
    }

    /**
     * Возвращает значение приведённое к int
     *
     * @return int
     */
    public function int(): int
    {
        return (int)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к string
     *
     * @return string
     */
    public function str(): string
    {
        return (string)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к boolean
     *
     * @return bool
     */
    public function bool(): bool
    {
        return (bool)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к double (float)
     *
     * @return float
     */
    public function double(): float
    {
        return (float)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к массиву
     *
     * @return array
     */
    public function array(): array
    {
        return (array)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к объекту
     *
     * @return object
     */
    public function object(): object
    {
        return (object)($this->asIs());
    }

    /**
     * Возвращает тип значения, одно из:
     * "boolean" "integer" "double"  "string" "array"
     * "object" "resource" "resource (closed)" "NULL" "unknown type"
     *
     * @return string
     */
    public function type(): string
    {
        return gettype($this->asIs());
    }

    /**
     * Использовать заданное значение в качестве значения по умолчанию
     *
     * @param mixed|null $value значение по умолчанию, будет присвоено
     *               если значение незаданное
     *
     * @return CommonValueInterface
     */
    public function default(mixed $value = null): CommonValueInterface
    {
        $this->default = $value;

        return $this;
    }
}
