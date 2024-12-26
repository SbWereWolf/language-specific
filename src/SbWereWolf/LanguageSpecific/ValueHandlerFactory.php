<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 7:57 AM
 */

namespace SbWereWolf\LanguageSpecific;


class ValueHandlerFactory implements ValueHandlerFactoryInterface
{
    public static function makeValueHandler(
        mixed $value = null
    ): ValueHandlerInterface {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new ValueHandler($value, true);

        return $result;
    }

    public static function
    makeValueHandlerWithoutValue(): ValueHandlerInterface
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new ValueHandler(null, false);

        return $result;
    }
}
