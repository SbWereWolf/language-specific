<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:35 AM
 */

namespace SbWereWolf\LanguageSpecific;

/**
 * Interface AdvancedArrayFactoryInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface AdvancedArrayFactoryInterface
{
    /**
     * Возвращает заглушку для AdvancedArrayInterface (без массива)
     *
     * @return AdvancedArrayInterface
     */
    public static function makeDummyAdvancedArray():
    AdvancedArrayInterface;

    /**
     * Возвращает AdvancedArrayInterface
     *
     * @param mixed $data массив значений
     *
     * @return AdvancedArrayInterface
     */
    public function makeAdvancedArray(
        mixed $data
    ): AdvancedArrayInterface;
}
