<?php
/**
 * PHP version 5.6
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 16.11.19 16:07
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
     * @var $_undefined null|self
     */
    private static $_undefined = null;

    /**
     * Значение по умолчанию для неопределённого значения,
     * используется когда значение не задано
     *
     * @var $_default null|self
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
     * @return self
     */
    public static function asUndefined()
    {
        $wasInit = !is_null(static::$_undefined);
        if (!$wasInit) {
            $handler = new static();
            $handler->_setUndefined();
            static::$_undefined = $handler;
        }

        return static::$_undefined;
    }

    /**
     * Установить значение незаданным
     *
     * @return self
     */
    private function _setUndefined()
    {
        $this->setHas(false)->setValue(null);

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

        return $this;
    }

    /**
     * @param bool $has
     */
    private function setHas($has)
    {
        $this->_has = $has;

        return $this;
    }
}
