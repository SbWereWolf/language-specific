<?php
/**
 * PHP version 7.0
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 16.11.19 16:11
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
