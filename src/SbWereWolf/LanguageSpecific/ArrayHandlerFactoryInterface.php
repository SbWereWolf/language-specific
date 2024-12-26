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

interface ArrayHandlerFactoryInterface
{
    /**
     * Возвращает ArrayHandlerInterface без массива
     *
     * @return ArrayHandlerInterface
     */
    public static function
    makeArrayHandlerWithoutArray(): ArrayHandlerInterface;

    /**
     * Возвращает ArrayHandlerInterface
     *
     * @param array $values массив значений
     * @return ArrayHandlerInterface
     */
    public function makeArrayHandler(
        array $values
    ): ArrayHandlerInterface;
}