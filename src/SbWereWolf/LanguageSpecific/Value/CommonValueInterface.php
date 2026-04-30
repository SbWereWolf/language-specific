<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
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
    public function isReal();

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
    public function int();

    /**
     * Возвращает значение приведённое к string
     *
     * @return string
     */
    public function str();

    /**
     * Возвращает значение приведённое к boolean
     *
     * @return bool
     */
    public function bool();

    /**
     * Возвращает значение приведённое к double (float)
     *
     * @return float
     */
    public function double();

    /**
     * Возвращает значение приведённое к array
     *
     * @return array<mixed,mixed>
     */
    public function asArray();

    /**
     * Возвращает значение приведённое к объекту
     *
     * @return object
     */
    public function object();

    /**
     * Возвращает тип значения, одно из:
     * "boolean" "integer" "double" "string" "array"
     * "object" "resource" "resource (closed)" "NULL" "unknown type"
     *
     * @return string
     */
    public function type();

    /**
     * Возвращает имя класса или тип значения
     *
     * @return string
     */
    public function getClass();

    /**
     * Возвращает текущее значение или значение по умолчанию
     *
     * @param mixed $value
     *
     * @return CommonValueInterface
     */
    public function setDefault($value = null);
}
