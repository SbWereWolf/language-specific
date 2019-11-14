<?php
/**
 * PHP version 7.0
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 14.11.19 23:44
 */

namespace LanguageSpecific;


/**
 * Class ValueHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
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
        $this->setValue($value)->setHas(true);
    }

    /**
     * Создать экземпляр с незаданным значением
     *
     * @return IValueHandler
     */
    public static function asUndefined(): IValueHandler
    {
        $wasInit = !is_null(ValueHandler::$_undefined);
        if (!$wasInit) {
            $handler = new ValueHandler();
            $handler->_setUndefined();
            ValueHandler::$_undefined = $handler;
        }

        return ValueHandler::$_undefined;
    }

    /**
     * Установить значение незаданным
     *
     * @return self
     */
    private function _setUndefined(): self
    {
        $this->setValue(null)->setHas(false);

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
     * Возвращает флаг "Имеет значение"
     *
     * @return bool
     */
    public function has(): bool
    {
        return $this->_has;
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
    public function type(): string
    {
        return gettype($this->asIs());
    }

    /**
     * Использовать зданное значение в качестве значения по умолчанию
     *
     * @param $value mixed значение по умолчанию, будет присвоено
     *               если значение незаданное
     *
     * @return IValueHandler
     */
    public function default($value = null): IValueHandler
    {
        $this->_default = $value;

        return $this;
    }

    /**
     * @param mixed $value of any type
     *
     * @return self
     */
    private function setValue($value): self
    {
        $this->_value = $value;

        return $this;
    }

    /**
     * @param bool $has
     *
     * @return self
     */
    private function setHas(bool $has): self
    {
        $this->_has = $has;

        return $this;
    }
}
