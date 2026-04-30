<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
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
    public function makeBaseArray($data);

    /**
     * Возвращает CommonArrayInterface
     *
     * @param mixed $data массив значений
     *
     * @return CommonArrayInterface
     */
    public function makeCommonArray($data);
}
