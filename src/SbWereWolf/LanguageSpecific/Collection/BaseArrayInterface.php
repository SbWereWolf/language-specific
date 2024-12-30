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

use Iterator;
use JsonSerializable;

/**
 * Interface BaseArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
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
