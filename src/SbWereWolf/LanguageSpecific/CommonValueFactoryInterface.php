<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 9:40 PM
 */

namespace SbWereWolf\LanguageSpecific;


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
