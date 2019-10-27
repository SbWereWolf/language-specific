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
 * 27.10.2019, 21:23
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

    /**
     * Синглтон для неопределённого значения (значение не задано)
     *
     * @var $_undefined null|ValueHandler
     */
    private static $_undefined = null;

    /**
     * Значение по умолчанию для неопределённого значения,
     * используется когда значение не задано
     *
     * @var $_default null|ValueHandler
     */
    private $_default = null;

    /**
     * Создать экземпляр с заданным значением
     *
     * @param $value mixed произвольное значение
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
        $this->setHas(true);
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
        $this->setHas(false);
        $this->setValue(null);

        return $this;
    }

    /**
     * Возвращает значение как есть
     *
     * @return mixed
     */
    public function asIs()
    {
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
     * Использовать зданное значение в качестве значения по умолчанию
     *
     * @param $value mixed значение по умолчанию, будет присвоено
     *               если значение незаданное
     *
     * @return self
     */
    public function with($value = null)
    {
        $this->_default = $value;

        return $this;
    }

    /**
     * @param mixed $value
     */
    private function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * @param bool $has
     */
    private function setHas($has)
    {
        $this->_has = $has;
    }
}
