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

use Generator;
use SbWereWolf\LanguageSpecific\Collection\CommonArrayInterface;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Interface AdvancedArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface AdvancedArrayInterface extends CommonArrayInterface
{
    /**
     * Возвращает флаг "является заглушкой"
     *
     * @return bool
     */
    public function isDummy(): bool;

    /**
     * Возвращает все элементы массива не являющиеся массивами.
     * Возвращает экземпляр с интерфейсом CommonValueInterface
     *
     * @return Generator<array-key, CommonValueInterface, mixed, void>
     */
    public function values(): Generator;

    /**
     * Возвращает AdvancedArrayInterface для вложенного массива
     *
     * @param bool|int|string|null|float $key индекс элемента с массивом
     *
     * @return AdvancedArrayInterface
     */
    public function pull(
        $key = null
    ): AdvancedArrayInterface;

    /**
     * Выдаёт все элементы массива являющиеся массивами.
     * Возвращает экземпляр с интерфейсом AdvancedArrayInterface
     *
     * @return Generator<array-key, AdvancedArrayInterface, mixed, void>
     */
    public function arrays(): Generator;
}
