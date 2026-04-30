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

use Iterator;
use JsonSerializable;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Interface BaseArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * @extends Iterator<array-key, CommonValueInterface>
 */
interface BaseArrayInterface extends Iterator, JsonSerializable
{
    /**
     * Возвращает исходный массив без обработки
     *
     * @return array<array-key, mixed>
     */
    public function raw();
}
