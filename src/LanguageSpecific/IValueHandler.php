<?php
/*
 * PHP version 7.0
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2020 Volkhin Nikolay
 * 08.10.2020, 3:09
 */

namespace LanguageSpecific;


/**
 * Interface IValueHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface IValueHandler
{
    /**
     * Создать экземпляр с незаданным значением
     *
     * @return self
     */
    public static function asUndefined(): self;

    /**
     * Возвращает флаг "Имеет значение"
     *
     * @return bool
     */
    public function has(): bool;

    /**
     * Возвращает значение как есть
     *
     * @return mixed
     */
    public function asIs();

    /**
     * Возвращает значение приведённое к int
     *
     * @return int
     */
    public function int(): int;

    /**
     * Возвращает значение приведённое к string
     *
     * @return string
     */
    public function str(): string;

    /**
     * Возвращает значение приведённое к boolean
     *
     * @return bool
     */
    public function bool(): bool;

    /**
     * Возвращает значение приведённое к double (float)
     *
     * @return float
     */
    public function double(): float;

    /**
     * Возвращает значение приведённое к массиву
     *
     * @return array
     */
    public function array(): array;

    /**
     * Возвращает значение приведённое к объекту
     *
     * @return object
     */
    public function object();

    /**
     * Возвращает тип значения, одно из:
     * "boolean" "integer" "double"  "string" "array"
     * "object" "resource" "resource (closed)" "NULL" "unknown type"
     *
     * @return string
     */
    public function type(): string;

    /**
     * Использовать заданное значение в качестве значения по умолчанию
     *
     * @param $value mixed значение по умолчанию, будет присвоено
     *               если значение незаданное
     *
     * @return self
     */
    public function default($value = null): self;
}
