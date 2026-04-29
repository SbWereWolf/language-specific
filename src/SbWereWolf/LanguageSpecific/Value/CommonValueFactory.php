<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/29/26, 12:53 PM
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
final class CommonValueFactory implements CommonValueFactoryInterface
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
