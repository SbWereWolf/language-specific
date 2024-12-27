<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:03 AM
 */

namespace SbWereWolf\LanguageSpecific;

interface AdvancedArrayFactoryInterface
{
    /**
     * Возвращает заглушку для AdvancedArrayInterface (без массива)
     *
     * @return AdvancedArrayInterface
     */
    public static function
    makeDummyAdvancedArray(): AdvancedArrayInterface;

    /**
     * Возвращает AdvancedArrayInterface
     *
     * @param array $data массив значений
     * @return AdvancedArrayInterface
     */
    public function makeAdvancedArray(
        mixed $data
    ): AdvancedArrayInterface;
}