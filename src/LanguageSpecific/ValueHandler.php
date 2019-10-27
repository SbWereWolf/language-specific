<?php
/**
 * PHP version 5.6
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 27.10.2019, 5:16
 */

namespace LanguageSpecific;


/**
 * Class ValueHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
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
     * Флаг "Значение задано"
     *
     * @var $_has bool
     */
    private $_has = false;

    private static $_undefined = null;

    /**
     * Создать экземпляр с заданным значением
     *
     * @param $value mixed произвольное значение
     */
    public function __construct($value = null)
    {
        $this->_value = $value;
        $this->_has = true;
    }

    /**
     * Создать экземпляр с незаданным значением
     *
     * @return ValueHandler
     */
    public static function asUndefined()
    {
        $handler = null;
        $wasInit = !is_null(ValueHandler::$_undefined);
        if (!$wasInit) {
            $handler = new ValueHandler();
            $handler->_setUndefined();
            ValueHandler::$_undefined = $handler;
        }
        if ($wasInit) {
            $handler = ValueHandler::$_undefined;
        }

        return $handler;
    }

    /**
     * Установить значение незаданным
     *
     * @return self
     */
    private function _setUndefined()
    {
        $this->_has = false;
        $this->_value = null;

        return $this;
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
     * Возвращает флаг "Имеет значение"
     *
     * @return bool
     */
    public function has()
    {
        return $this->_has;
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
