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


class Factory implements IFactory
{
    public static function getValueHandler($value = null)
    {
        $result = new ValueHandler($value);

        return $result;
    }

    public static function getUndefinedValue()
    {
        $result = ValueHandler::asUndefined();

        return $result;
    }
}
