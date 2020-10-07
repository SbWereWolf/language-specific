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


class Factory implements IFactory
{
    public static function getValueHandler($value = null)
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new ValueHandler($value);

        return $result;
    }

    public static function getUndefinedValue()
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = ValueHandler::asUndefined();

        return $result;
    }
}
