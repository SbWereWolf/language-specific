<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2020 Volkhin Nikolay
 * 08.10.2020, 3:48
 */

/**
 * PHP version 5.6
 *
 * @category Library
 */

namespace LanguageSpecific;


/**
 * Class ValueHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ValueHandler implements IValueHandler
{
    /**
     * Собственно значение
     *
     * @var $_value mixed
     */
    private $_value = null;

    /**
     * Флаг "Значение задано"
     *
     * @var $_has bool
     */
    private $_has = false;

    /**
     * Значение по умолчанию для неопределённого значения,
     * используется когда значение не задано
     *
     * @var $_default mixed произвольное значение
     */
    private $_default = null;

    /**
     * Создать экземпляр с заданным значением
     *
     * @param $value mixed произвольное значение
     */
    public function __construct($value = null)
    {
        $this->setValue($value)->setHas(true);
    }

    /**
     * Создать экземпляр с незаданным значением
     *
     * @return IValueHandler
     */
    public static function asUndefined()
    {
        $handler = new static();
        $handler->_setUndefined();

        return $handler;
    }

    /**
     * Установить значение незаданным
     *
     * @return IValueHandler
     */
    private function _setUndefined()
    {
        $this->setHas(false);

        return $this;
    }

    /**
     * Возвращает флаг "Имеет значение"
     *
     * @return bool
     */
    public function has()
    {
        return $this->_has;
    }

    /**
     * Возвращает значение как оно есть
     *
     * @return mixed
     */
    public function asIs()
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = $this->has() ? $this->_value : $this->_default;

        return $result;
    }

    /**
     * Возвращает значение приведённое к int
     *
     * @return int
     */
    public function int()
    {
        return (int)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к string
     *
     * @return string
     */
    public function str()
    {
        return (string)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к boolean
     *
     * @return bool
     */
    public function bool()
    {
        return (bool)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к double (float)
     *
     * @return float
     */
    public function double()
    {
        return (float)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к массиву
     *
     * @return array
     */
    public function asArray()
    {
        return (array)($this->asIs());
    }

    /**
     * Возвращает значение приведённое к объекту
     *
     * @return object
     */
    public function object()
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
    public function type()
    {
        return gettype($this->asIs());
    }

    /**
     * Использовать заданное значение в качестве значения по умолчанию
     *
     * @param $value mixed значение по умолчанию, будет присвоено
     *               если значение незаданное
     *
     * @return IValueHandler
     */
    public function with($value = null)
    {
        $this->_default = $value;

        return $this;
    }

    /**
     * @param mixed $value of any type
     *
     * @return self
     */
    private function setValue($value)
    {
        $this->_value = $value;

        return $this;
    }

    /**
     * @param bool $has
     *
     * @return IValueHandler
     */
    private function setHas($has)
    {
        $this->_has = $has;

        return $this;
    }
}
