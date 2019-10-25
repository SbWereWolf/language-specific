<?php
/**
 * LanguageSpecific
 * Copyright © 2019 Volkhin Nikolay
 * 26.10.2019, 3:02
 */

namespace LanguageFeatures;


use Generator;

class ArrayHandler
{
    /**
     * МАссив с данными
     *
     * @var $data
     */
    private $data = array();

    /**
     * ArrayHandler constructor.
     * Принимает масив,
     * либо значение которое можно привести к массиву
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = (array)$data;
    }

    /**
     * Получить элемент массива
     *
     * @param $key mixed индекс элемента
     *
     * @return ValueHandler
     */
    public function get($key = null): ValueHandler
    {
        $data = $this->data;
        $isNull = is_null($key);
        if ($isNull) {
            $value = new ValueHandler(current($data));
        }
        if (!$isNull) {
            $value = array_key_exists($key, $data)
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
    public function simplify(): self
    {
        $reduced = [];
        foreach ($this->data as $key => $value) {
            $isNested = is_array($value);
            if (!$isNested) {
                $reduced[$key] = $value;
            }
        }
        foreach ($this->data as $nested) {
            $isNested = is_array($nested);
            if ($isNested) {
                $reduced[] = current($nested);
            }
        }
        $this->data = $reduced;

        return $this;
    }

    /**
     * Извлекает следующий элемент массива
     * Значение будет экземпляром класса LanguageFeatures\ValueHandler
     *
     * @return Generator
     */
    public function next()
    {
        foreach ($this->data as $value) {
            $content = new ValueHandler($value);
            yield $content;
        }
        reset($this->data);
    }
}
