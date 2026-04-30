<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
 */

namespace SbWereWolf\LanguageSpecific\Value;

/**
 * Interface CommonValueFactoryInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface CommonValueFactoryInterface
{
    /**
     * Возвращает CommonValueInterface
     *
     * @param mixed $value значение элемента
     *
     * @return CommonValueInterface
     */
    public static function makeCommonValue(
        $value = null
    );

    /**
     * Возвращает CommonValueInterface с незаданным значением
     *
     * @return CommonValueInterface
     */
    public static function makeCommonValueAsDummy();
}
