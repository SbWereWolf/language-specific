<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2025 Volkhin Nikolay
 * 7/30/25, 11:18 AM
 */

namespace SbWereWolf\LanguageSpecific\Value;

/**
 * Interface CommonValueInterface
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
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
     * @return array<mixed,mixed>
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
     * "boolean" "integer" "double" "string" "array"
     * "object" "resource" "resource (closed)" "NULL" "unknown type"
     *
     * @return string
     */
    public function type(): string;

    /**
     * Возвращает тип значения или имя класса, одно из:
     * "int" "float" "bool" "string" "array" "null"
     * A class name for named classes
     * "class@anonymous" for an anonymous classes
     * "resource (xxx)" for resources where "xxx" is a name of resource
     * "resource (closed)" for closed resources
     *
     * @return string
     */
    public function class(): string;

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
