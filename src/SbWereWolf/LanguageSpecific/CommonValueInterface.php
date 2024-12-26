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


/**
 * Interface CommonValueInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
interface CommonValueInterface
{
    /**
     * Возвращает флаг "Значение было задано"
     *
     * @return bool
     */
    public function isReal(): bool;

    /**
     * Возвращает значение как есть
     *
     * @return mixed
     */
    public function asIs(): mixed;

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
    public function object(): object;

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
     * @param $value mixed|null значение по умолчанию, будет присвоено
     *               если значение незаданное
     *
     * @return CommonValueInterface
     */
    public function default(mixed $value = null): CommonValueInterface;
}
