<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 9:40 PM
 */

namespace SbWereWolf\LanguageSpecific;

use Generator;

/**
 * Interface AdvancedArrayInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface AdvancedArrayInterface extends CommonArrayInterface
{
    /**
     * Возвращает все элементы массива не являющиеся массивами.
     * Возвращает экземпляр с интерфейсом CommonValueInterface
     *
     * @return Generator
     */
    public function values(): Generator;

    /**
     * Возвращает AdvancedArrayInterface для вложенного массива
     *
     * @param bool|int|string|null $key индекс элемента с массивом
     *
     * @return AdvancedArrayInterface
     */
    public function pull(
        int|bool|string|null|float $key = null
    ): AdvancedArrayInterface;

    /**
     * Выдаёт все элементы массива являющиеся массивами.
     * Возвращает экземпляр с интерфейсом AdvancedArrayInterface
     *
     * @return Generator
     */
    public function arrays(): Generator;
}
