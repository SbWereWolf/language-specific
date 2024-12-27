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

use Iterator;
use JsonSerializable;

/**
 * Interface BaseArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface BaseArrayInterface extends Iterator, JsonSerializable
{
    /**
     * Возвращает исходный массив без обработки
     *
     * @return array
     */
    public function raw(): array;
}
