<?php
/**
 * PHP version 7.0
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 16.11.19 16:11
 */

namespace LanguageSpecific;


use Generator;

/**
 * Class ArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.0/LICENSE
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
     * Принимает масив,
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
        if (is_null($factory)) {
            $this->factory = new Factory();
        }
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
        $value = $this->factory->getUndefinedValue();
        $payload = (new KeySearcher($this->_data))->search($key);
        if ($payload->has()) {
            $key = $payload->key();
            $value = $this->factory->getValueHandler($this->_data[$key]);
        }

        return $value;
    }

    /**
     * Если элемент массива является массивом, то
     * элементу присваивает значение первого элемента вложенного массива
     *
     * @param array $needful = [] необходимые индексы, если аргумент
     *                            задан, то для вложенных массивов
     *                            будут возвращены элементы только с
     *                            заданными индексами
     *
     * @return IArrayHandler
     */
    public function simplify(array $needful = []): IArrayHandler
    {
        $letFilter = !empty($needful);
        if ($letFilter) {
            array_flip($needful);
        }
        $reduced = [];
        foreach ($this->_data as $key => $value) {
            $isNested = is_array($value);
            if (!$isNested) {
                $reduced[$key] = $value;
            }
        }
        foreach ($this->_data as $key => $nested) {
            $isNested = is_array($nested);
            if ($isNested && !$letFilter) {
                $reduced[] = current($nested);
            }
            $pickedUp = [];
            if ($isNested && $letFilter) {
                foreach ($needful as $item => $index) {
                    if (key_exists($index, $nested)) {
                        $pickedUp[$index] = $nested[$index];
                    }
                }

            }
            $letObtain = !empty($pickedUp);
            if ($letObtain) {
                $reduced[] = $pickedUp;
            }

        }
        $result = new static($reduced);

        return $result;
    }

    /**
     * Извлекает следующий элемент массива
     * Значение будет экземпляром класса IValueHandler
     *
     * @return Generator
     */
    public function next()
    {
        foreach ($this->_data as $value) {
            $content = $this->factory->getValueHandler($value);
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

    /**
     * Возвращает IArrayHandler для вложенного массива
     *
     * @param $key mixed индекс элемента с вложенным массивом
     *
     * @return IArrayHandler
     */
    public function pull($key = null): IArrayHandler
    {
        $nested = $this->get($key);
        $isDefined = $nested->has();
        $isArray = false;
        if ($isDefined) {
            $isArray = $nested->type() === 'array';
        }
        $pulled = static::asUndefined();
        if ($isDefined && $isArray) {
            $pulled = new static($nested->asIs());
        }

        return $pulled;
    }
}
