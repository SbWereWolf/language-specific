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

interface AdvancedArrayFactoryInterface
{
    /**
     * Возвращает ArrayHandlerInterface без массива
     *
     * @return AdvancedArrayInterface
     */
    public static function
    makeDummyAdvancedArray(): AdvancedArrayInterface;

    /**
     * Возвращает ArrayHandlerInterface
     *
     * @param array $values массив значений
     * @return AdvancedArrayInterface
     */
    public function makeAdvancedArray(
        array $values
    ): AdvancedArrayInterface;
}