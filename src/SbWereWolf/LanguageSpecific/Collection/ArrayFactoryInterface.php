<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 6:24 AM
 */

namespace SbWereWolf\LanguageSpecific\Collection;

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