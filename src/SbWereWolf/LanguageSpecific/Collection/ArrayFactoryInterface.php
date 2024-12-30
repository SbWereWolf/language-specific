<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:05 AM
 */

namespace SbWereWolf\LanguageSpecific\Collection;

/**
 * Interface ArrayFactoryInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface ArrayFactoryInterface
{
    /**
     * Возвращает BaseArrayInterface
     *
     * @param mixed $data массив значений
     *
     * @return BaseArrayInterface
     */
    public function makeBaseArray(mixed $data): BaseArrayInterface;

    /**
     * Возвращает CommonArrayInterface
     *
     * @param mixed $data массив значений
     *
     * @return CommonArrayInterface
     */
    public function makeCommonArray(mixed $data): CommonArrayInterface;
}