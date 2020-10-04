<?php
/**
 * PHP version 7.2
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 16.11.19 15:43
 */

namespace LanguageSpecific;


class Factory implements IFactory
{
    public static function getValueHandler($value = null): IValueHandler
    {
        $result = new ValueHandler($value);

        return $result;
    }

    public static function getUndefinedValue(): IValueHandler
    {
        $result = ValueHandler::asUndefined();

        return $result;
    }
}
