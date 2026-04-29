<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/29/26, 8:46 PM
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
    public function makeDummyAdvancedArray():
    AdvancedArrayInterface;

    /**
     * Возвращает AdvancedArrayInterface
     *
     * @param mixed $data массив значений
     *
     * @return AdvancedArrayInterface
     */
    public function makeAdvancedArray(
        $data
    ): AdvancedArrayInterface;
}
