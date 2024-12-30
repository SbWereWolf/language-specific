<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 8:46 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Value;


class CommonValueFactory implements CommonValueFactoryInterface
{
    public static function makeCommonValue(
        mixed $value = null
    ): CommonValueInterface {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new CommonValue($value, true);

        return $result;
    }

    public static function
    makeCommonValueAsDummy(): CommonValueInterface
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new CommonValue(null, false);

        return $result;
    }
}
