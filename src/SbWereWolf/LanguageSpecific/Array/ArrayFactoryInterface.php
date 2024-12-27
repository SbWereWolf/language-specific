<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:03 AM
 */

namespace SbWereWolf\LanguageSpecific\Array;

interface ArrayFactoryInterface
{
    /**
     * Возвращает BaseArrayInterface
     *
     * @param mixed $data массив значений
     * @return BaseArrayInterface
     */
    public function makeBaseArray(mixed $data): BaseArrayInterface;

    /**
     * Возвращает CommonArrayInterface
     *
     * @param mixed $data массив значений
     * @return CommonArrayInterface
     */
    public function makeCommonArray(mixed $data): CommonArrayInterface;
}