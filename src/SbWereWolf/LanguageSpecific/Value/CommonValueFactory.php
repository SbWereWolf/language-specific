<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:35 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific\Value;

/**
 * Interface CommonValueFactory
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
class CommonValueFactory implements CommonValueFactoryInterface
{
    /** @inheritDoc */
    public static function makeCommonValue(
        mixed $value = null
    ): CommonValueInterface {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new CommonValue($value, true);

        return $result;
    }

    /** @inheritDoc */
    public static function makeCommonValueAsDummy():
    CommonValueInterface
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = new CommonValue(null, false);

        return $result;
    }
}
