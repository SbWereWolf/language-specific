<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2020 Volkhin Nikolay
 * 08.10.2020, 3:45
 */

/**
 * PHP version 7.0
 *
 * @category Library
 */

namespace LanguageSpecific;


class Factory implements IFactory
{
    public static function getValueHandler($value = null): IValueHandler
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new ValueHandler($value);

        return $result;
    }

    public static function getUndefinedValue(): IValueHandler
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = ValueHandler::asUndefined();

        return $result;
    }
}
