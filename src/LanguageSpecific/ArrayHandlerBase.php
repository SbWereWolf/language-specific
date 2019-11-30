<?php
/**
 * PHP version 7.0
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 30.11.19 21:14
 */

namespace LanguageSpecific;


/**
 * Class ArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandlerBase
{
    /**
     * Массив с данными
     *
     * @var $_data array массив с которым работает класс
     */
    protected $_data = [];

    /**
     * Синглтон для неопределённого значения (значение не задано)
     *
     * @var $_undefined null|static
     */
    private static $_undefined = null;

    private $isUndefined = true;

    /**
     * возвращает флаг "Массив не задан"
     *
     * @return bool
     */
    public function isUndefined(): bool
    {
        return $this->isUndefined;
    }

    /**
     * Возвращает с незаданным значением
     *
     * @return static
     */
    protected static function asUndefined()
    {
        $wasInit = !is_null(self::$_undefined);
        if (!$wasInit) {
            $handler = new static();
            $handler->_setUndefined();
            self::$_undefined = $handler;
        }

        return self::$_undefined;
    }

    /**
     * Установить значение незаданным
     *
     * @return static
     */
    private function _setUndefined()
    {
        $this->isUndefined = true;

        return $this;
    }

    /**
     * Установить как не заданное
     *
     * @return static
     */
    protected function setAsDefined()
    {
        $this->isUndefined = false;

        return $this;
    }
}
