<?php
/**
 * PHP version 5.6
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 29.10.2019, 2:58
 */

namespace LanguageSpecific;


use Generator;

/**
 * Class ArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandler implements IArrayHandler
{
    /**
     * Массив с данными
     *
     * @var $_data array массив с которым работает класс
     */
    private $_data = array();

    /**
     * ArrayHandler constructor.
     * Принимает масив,
     * либо значение которое можно привести к массиву
     *
     * @param $data array|int|float|bool|string|object массив или
     *              значимый тип
     */
    public function __construct($data = null)
    {
        $source = $data;
        $isArray = is_array($data);
        if (!$isArray) {
            $source = [$data];
        }
        $this->_data = $source;
    }

    /**
     * Получить элемент массива
     *
     * @param $key int|float|bool|string|null индекс элемента
     *
     * @return IValueHandler
     */
    public function get($key = null): IValueHandler
    {
        $value = ValueHandler::asUndefined();
        $payload = (new KeySearcher($this->_data))->search($key);
        if ($payload->has()) {
            $key = $payload->key();
            $value = new ValueHandler($this->_data[$key]);
        }

        return $value;
    }

    /**
     * Если элемент массива является массивом, то
     * элементу присваивает значение первого элемента вложенного массива
     *
     * @return IArrayHandler
     */
    public function simplify(): IArrayHandler
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
     * Значение будет экземпляром класса \LanguageSpecific\ValueHandler
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

    /**
     * Проверяет имеет ли массив заданных индекс
     *
     * @param $key int|float|bool|string|null индекс искомого элемента
     *
     * @return bool
     */
    public function has($key = null): bool
    {
        $output = (new KeySearcher($this->_data))->search($key);
        $result = $output->has();

        return $result;
    }
}
