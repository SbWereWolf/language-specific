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


interface IFactory
{
    /**
     * Возвращает IValueHandler
     *
     * @param null $value значение элемента
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
