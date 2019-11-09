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
 * 09.11.19 23:58
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
    private $_data = [];

    /**
     * Синглтон для неопределённого значения (значение не задано)
     *
     * @var $_undefined null|ArrayHandler
     */
    private static $_undefined = null;

    private $isUndefined = true;

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
        $this->isUndefined = false;
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
        $result = new ArrayHandler($reduced);

        return $result;
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
        $pulled = ArrayHandler::asUndefined();
        if ($isDefined && $isArray) {
            $pulled = new ArrayHandler($nested->asIs());
        }

        return $pulled;
    }

    /**
     * возвращает флаг "Массив не задан"
     *
     * @return bool
     */
    public function isUndefined(): bool
    {
        return $this->isUndefined;
    }

    /**
     * Возвращает с незаданным значением
     *
     * @return self
     */
    private static function asUndefined(): self
    {
        $wasInit = !is_null(ArrayHandler::$_undefined);
        if (!$wasInit) {
            $handler = new ArrayHandler();
            $handler->_setUndefined();
            ArrayHandler::$_undefined = $handler;
        }

        return ArrayHandler::$_undefined;
    }

    /**
     * Установить значение незаданным
     *
     * @return self
     */
    private function _setUndefined(): self
    {
        $this->isUndefined = true;
        $this->_data = [];

        return $this;
    }
}
