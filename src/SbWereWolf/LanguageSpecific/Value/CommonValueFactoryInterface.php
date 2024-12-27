<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:03 AM
 */

namespace SbWereWolf\LanguageSpecific\Value;


interface CommonValueFactoryInterface
{
    /**
     * Возвращает CommonValueInterface
     *
     * @param mixed $value значение элемента
     * @return CommonValueInterface
     */
    public static function makeCommonValue(
        mixed $value = null
    ): CommonValueInterface;

    /**
     * Возвращает CommonValueInterface с незаданным значением
     *
     * @return CommonValueInterface
     */
    public static function
    makeCommonValueAsDummy(): CommonValueInterface;
}
