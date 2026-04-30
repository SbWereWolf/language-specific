<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
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
    public function makeDummyAdvancedArray();

    /**
     * Возвращает AdvancedArrayInterface
     *
     * @param mixed $data массив значений
     *
     * @return AdvancedArrayInterface
     */
    public function makeAdvancedArray(
        $data
    );
}
