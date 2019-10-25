<?php
/**
 * LanguageSpecific
 * Copyright © 2019 Volkhin Nikolay
 * 26.10.2019, 3:02
 */

namespace LanguageFeatures;


class ValueHandler
{
    /**
     * Собственно значение
     *
     * @var $value mixed
     */
    private $value;

    /**
     * Флаг "Значение является пустым"
     *
     * @var $isNull bool
     */
    private $isNull = true;

    /**
     * ValueHandler constructor.
     * Принимает произвольное значение
     *
     * @param $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
        $this->isNull = is_null($value);
    }

    /**
     * Возвращает значение как есть
     *
     * @return mixed
     */
    public function asIs()
    {
        return $this->value;
    }

    /**
     * Возвращает значение приведённое к int
     *
     * @return int
     */
    public function int(): int
    {
        return (int)($this->value);
    }

    /**
     * Возвращает значение приведённое к string
     *
     * @return string
     */
    public function str(): string
    {
        return (string)($this->value);
    }

    /**
     * Возвращает значение приведённое к boolean
     *
     * @return bool
     */
    public function bool(): bool
    {
        return (bool)($this->value);
    }

    /**
     * Возвращает значение приведённое к double
     *
     * @return float
     */
    public function double(): float
    {
        return (float)($this->value);
    }

    /**
     * Флаг "Значение является пустым"
     *
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->isNull;
    }

    /**
     * Возвращает значение приведённое к массиву
     *
     * @return array
     */
    public function array(): array
    {
        return (array)($this->value);
    }

    /**
     * Возвращает значение приведённое к объекту
     *
     * @return object
     */
    public function object(): object
    {
        return (object)($this->value);
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
        return gettype($this->value);
    }
}
