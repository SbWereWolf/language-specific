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


interface ValueHandlerFactoryInterface
{
    /**
     * Возвращает ValueHandlerInterface
     *
     * @param mixed $value значение элемента
     * @return ValueHandlerInterface
     */
    public static function makeValueHandler(
        mixed $value = null
    ): ValueHandlerInterface;

    /**
     * Возвращает ValueHandlerInterface с незаданным значением
     *
     * @return ValueHandlerInterface
     */
    public static function
    makeValueHandlerWithoutValue(): ValueHandlerInterface;
}
