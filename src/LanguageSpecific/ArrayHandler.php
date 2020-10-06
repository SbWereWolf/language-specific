<?php
/**
 * PHP version 7.2
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 30.11.19 21:13
 */

namespace LanguageSpecific;


use Generator;

/**
 * Class ArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandler extends ArrayHandlerBase
    implements IArrayHandler
{
    /**
     * @var IFactory
     */
    private $factory = null;

    /**
     * ArrayHandler constructor.
     * Принимает массив,
     * либо значение которое можно привести к массиву
     *
     * @param $data array|int|float|bool|string|object массив или
     *              значимый тип
     */
    public function __construct($data = null, $factory = null)
    {
        $source = $data;
        $isArray = is_array($data);
        if (!$isArray) {
            $source = [$data];
        }
        $this->_data = $source;
        $this->setAsDefined();

        if ($factory instanceof IFactory) {
            $this->factory = $factory;
        }
        if(is_null($factory)){
            $this->factory = new Factory();
        }
    }

    /**
     * Проверяет имеет ли массив заданный индекс
     *
     * @param $key int|bool|string|null индекс искомого элемента
     *
     * @return bool
     */
    public function has($key = null): bool
    {
        $output = (new KeySearcher($this->_data))->search($key);
        $result = $output->has();

        return $result;
    }

    /**
     * Получить элемент массива
     *
     * @param $key int|bool|string|null индекс элемента
     *
     * @return IValueHandler
     */
    public function get($key = null): IValueHandler
    {
        $value = $this->factory->getUndefinedValue();
        $payload = (new KeySearcher($this->_data))->search($key);
        if ($payload->has()) {
            $key = $payload->key();
            $value = $this->factory->getValueHandler($this->_data[$key]);
        }

        return $value;
    }

    /**
     * @return Generator
     */
    public function getting()
    {
        $keys = array_keys($this->_data);
        foreach ($keys as $key) {
            $value = $this->get($key);
            $isArray = $value->type() === 'array';

            if (!$isArray) {
                yield $key => $value;
            }
        }
    }

    /**
     * Возвращает IArrayHandler для вложенного массива
     *
     * @param $key int|bool|string|null индекс элемента с массивом
     *
     * @return IArrayHandler
     */
    public function pull($key = null): IArrayHandler
    {
        $nested = $this->get($key);
        $isExists = $nested->has();
        $isArray = false;
        if ($isExists) {
            $isArray = $nested->type() === 'array';
        }
        $pulled = static::asUndefined();
        if ($isArray) {
            $pulled = new static($nested->asIs(), $this->factory);
        }

        return $pulled;
    }

    /**
     * Извлекает следующий массив
     * Значение будет экземпляром интерфейса IArrayHandler
     *
     * @return Generator
     */
    public function pulling()
    {
        $keys = array_keys($this->_data);
        foreach ($keys as $key) {
            $nextArray = $this->pull($key);

            $isExists = !$nextArray->isUndefined();
            if ($isExists) {
                yield $key => $nextArray;
            }
        }
    }

    /**
     * Возвращает исходный массив
     *
     * @return array
     */
    public function raw(): array
    {
        return $this->_data;
    }

    public function rewind()
    {
        reset($this->_data);
    }

    public function current()
    {
        return new ValueHandler(current($this->_data));
    }

    public function key()
    {
        return key($this->_data);
    }

    public function next()
    {
        next($this->_data);
    }

    public function valid()
    {
        return key_exists(key($this->_data), $this->_data);
    }
}
