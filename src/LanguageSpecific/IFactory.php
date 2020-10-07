<?php
/**
 * PHP version 5.6
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 16.11.19 16:07
 */

namespace LanguageSpecific;


interface IFactory
{
    /**
     * Возвращает IValueHandler
     *
     * @return IValueHandler
     */
    public static function getValueHandler($value = null);

    /**
     * Возвращает IValueHandler с незаданным значением
     *
     * @return IValueHandler
     */
    public static function getUndefinedValue();
}
