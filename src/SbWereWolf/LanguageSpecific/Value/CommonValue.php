<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
 */


namespace SbWereWolf\LanguageSpecific\Value;

/**
 * Class CommonValue
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
final class CommonValue implements CommonValueInterface
{
    /** @var mixed */
    private $value;
    /** @var bool */
    private $isReal;

    /**
     * Создать экземпляр с заданным значением
     *
     * @param mixed $value Произвольное значение
     * @param bool $isReal Значение является действительным
     */
    public function __construct(
        $value = null,
        $isReal = true
    ) {
        $this->value = $value;
        $this->isReal = $isReal;
    }

    /** @inheritDoc */
    public function isReal()
    {
        return $this->isReal === true;
    }

    /** @inheritDoc */
    public function asIs()
    {
        return $this->value;
    }

    /** @inheritDoc */
    public function int()
    {
        return (int)($this->asIs());
    }

    /** @inheritDoc */
    public function str()
    {
        return (string)($this->asIs());
    }

    /** @inheritDoc */
    public function bool()
    {
        return (bool)($this->asIs());
    }

    /** @inheritDoc */
    public function double()
    {
        return (float)($this->asIs());
    }

    /** @inheritDoc */
    public function asArray()
    {
        return (array)($this->asIs());
    }

    /** @inheritDoc */
    public function object()
    {
        return (object)($this->asIs());
    }

    /** @inheritDoc */
    public function type()
    {
        $type = gettype($this->asIs());
        if ($type !== 'unknown type') {
            return $type;
        }

        return $this->debugType($this->asIs()) === 'resource (closed)' ? 'resource (closed)' : $type;
    }

    /** @inheritDoc */
    public function setDefault($value = null)
    {
        if ($this->isReal()) {
            return $this;
        }

        return new self($value, false);
    }

    /** @inheritDoc */
    public function getClass()
    {
        return $this->debugType($this->asIs());
    }

    /**
     * Возвращает имя типа для вывода пользователю.
     *
     * @param mixed $value
     *
     * @return string
     */
    private function debugType($value)
    {
        $type = gettype($value);

        if ($type === 'NULL') {
            return 'null';
        }

        if ($type === 'boolean') {
            return 'bool';
        }

        if ($type === 'integer') {
            return 'int';
        }

        if ($type === 'double') {
            return 'float';
        }

        if ($type === 'object') {
            return get_class($value);
        }

        if ($type === 'resource') {
            return 'resource (' . get_resource_type($value) . ')';
        }

        if ($type === 'unknown type') {
            return 'resource (closed)';
        }

        return $type;
    }
}
