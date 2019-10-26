<?php
/**
 * LanguageSpecific
 * Copyright © 2019 Volkhin Nikolay
 * 26.10.2019, 14:10
 */

/**
 * PHP version 5.6
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/develop/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */

namespace LanguageSpecific;


use Generator;

/**
 * Class ArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/develop/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandler
{
    /**
     * Массив с данными
     *
     * @var $_data
     */
    private $_data = array();

    /**
     * ArrayHandler constructor.
     * Принимает масив,
     * либо значение которое можно привести к массиву
     *
     * @param $data array|object набор данных, массив или объект
     */
    public function __construct($data)
    {
        $this->_data = (array)$data;
    }

    /**
     * Получить элемент массива
     *
     * @param $key mixed индекс элемента
     *
     * @return ValueHandler
     */
    public function get($key = null)
    {
        $data = $this->_data;
        $isNull = is_null($key);
        $value = null;
        if ($isNull) {
            $value = new ValueHandler(current($data));
        }
        if (!$isNull) {
            $value = key_exists($key, $data)
                ? new ValueHandler($data[$key])
                : new ValueHandler();
        }

        return $value;
    }

    /**
     * Если элемент массива является массивом, то
     * элементу присваивает значение первого элемента вложенного массива
     *
     * @return self
     */
    public function simplify()
    {
        $reduced = [];
        foreach ($this->_data as $key => $value) {
            $isNested = is_array($value);
            if (!$isNested) {
                $reduced[$key] = $value;
            }
        }
        foreach ($this->_data as $nested) {
            $isNested = is_array($nested);
            if ($isNested) {
                $reduced[] = current($nested);
            }
        }
        $this->_data = $reduced;

        return $this;
    }

    /**
     * Извлекает следующий элемент массива
     * Значение будет экземпляром класса LanguageSpecific\ValueHandler
     *
     * @return Generator
     */
    public function next()
    {
        foreach ($this->_data as $value) {
            $content = new ValueHandler($value);
            yield $content;
        }
        reset($this->_data);
    }
}
