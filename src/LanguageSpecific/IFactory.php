<?php
/**
 * PHP version 7.2
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 16.11.19 15:46
 */

namespace LanguageSpecific;


interface IFactory
{
    /**
     * Возвращает IValueHandler
     *
     * @return IValueHandler
     */
    public static function getValueHandler($value = null): IValueHandler;

    /**
     * Возвращает IValueHandler с незаданным значением
     *
     * @return IValueHandler
     */
    public static function getUndefinedValue(): IValueHandler;
}
