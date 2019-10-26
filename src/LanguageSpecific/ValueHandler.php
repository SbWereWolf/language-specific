<?php
/**
 * LanguageSpecific
 * Copyright © 2019 Volkhin Nikolay
 * 26.10.2019, 14:23
 */

/**
 * PHP version 5.6
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT
 *           https://github.com/SbWereWolf/language-specific/blob/develop/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */

namespace LanguageSpecific;


/**
 * Class ValueHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/develop/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ValueHandler
{
    /**
     * Собственно значение
     *
     * @var $_value mixed
     */
    private $_value;

    /**
     * Флаг "Значение является пустым"
     *
     * @var $_isNull bool
     */
    private $_isNull = true;

    /**
     * ValueHandler constructor.
     * Принимает произвольное значение
     *
     * @param $value mixed произволное значение
     */
    public function __construct($value = null)
    {
        $this->_value = $value;
        $this->_isNull = is_null($value);
    }

    /**
     * Возвращает значение как есть
     *
     * @return mixed
     */
    public function asIs()
    {
        return $this->_value;
    }

    /**
     * Возвращает значение приведённое к int
     *
     * @return int
     */
    public function int()
    {
        return (int)($this->_value);
    }

    /**
     * Возвращает значение приведённое к string
     *
     * @return string
     */
    public function str()
    {
        return (string)($this->_value);
    }

    /**
     * Возвращает значение приведённое к boolean
     *
     * @return bool
     */
    public function bool()
    {
        return (bool)($this->_value);
    }

    /**
     * Возвращает значение приведённое к double
     *
     * @return float
     */
    public function double()
    {
        return (float)($this->_value);
    }

    /**
     * Флаг "Значение является пустым"
     *
     * @return bool
     */
    public function isNull()
    {
        return $this->_isNull;
    }

    /**
     * Возвращает значение приведённое к массиву
     *
     * @return array
     */
    public function asArray()
    {
        return (array)($this->_value);
    }

    /**
     * Возвращает значение приведённое к объекту
     *
     * @return object
     */
    public function object()
    {
        return (object)($this->_value);
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
        return gettype($this->_value);
    }
}
