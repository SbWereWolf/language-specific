<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2025 Volkhin Nikolay
 * 7/30/25, 11:16 AM
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
     * @return array<mixed,mixed>
     */
    public function raw(): array;
}
