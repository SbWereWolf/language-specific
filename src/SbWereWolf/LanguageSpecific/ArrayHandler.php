<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 7:57 AM
 */

namespace SbWereWolf\LanguageSpecific;


use Generator;

/**
 * Class ArrayHandler
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandler extends ArrayHandlerBase
    implements ArrayHandlerInterface
{
    private ArrayHandlerFactory $arrayFactory;

    /**
     * ArrayHandler constructor.
     * Принимает массив,
     * либо значение которое можно привести к массиву
     *
     * @param array $data массив
     * @param ValueHandlerFactoryInterface|null $valueFactory
     *  фабрика для создания экземпляров ValueHandlerInterface
     * @param ArrayHandlerFactoryInterface|null $arrayFactory
     * фабрика для создания новых экземпляров ArrayHandlerInterface
     * @param bool $isDummy
     *          флаг "является заглушкой для несуществующего массива"
     */
    public function __construct(
        array $data,
        ValueHandlerFactoryInterface|null $valueFactory = null,
        ArrayHandlerFactoryInterface|null $arrayFactory = null,
        bool $isDummy = false,
    ) {
        parent::__construct($data, $valueFactory);

        if (is_null($arrayFactory)) {
            $this->arrayFactory =
                new ArrayHandlerFactory($this->valueFactory);
        }
        if ($arrayFactory instanceof ArrayHandlerFactoryInterface) {
            $this->arrayFactory = $arrayFactory;
        }

        if ($isDummy) {
            $this->_data = [];
            $this->riseWasNotDefined();
        }
        if (!$isDummy) {
            $this->_data = array_replace([], $data);
            $this->dropWasNotDefined();
        }
    }

    /**
     * Возвращает все элементы массива не являющиеся массивами
     * Возвращает экземпляр с интерфейсом ValueHandlerInterface
     *
     * @return Generator
     */
    public function getting(): Generator
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
     * По индексу получить элемент массива
     * Возвращает экземпляр с интерфейсом ValueHandlerInterface
     *
     * @param int|bool|string|null|float $key индекс элемента
     *
     * @return ValueHandlerInterface
     */
    public function get(
        int|bool|string|null|float $key = null
    ): ValueHandlerInterface {
        $value = $this->valueFactory->makeValueHandlerWithoutValue();
        $payload = (new KeySearcher($this->_data))->search($key);
        if ($payload->has()) {
            $key = $payload->key();
            $value = $this->valueFactory->makeValueHandler(
                $this->_data[$key]
            );
        }

        return $value;
    }

    /**
     * Проверяет, что массив имеет элемент с заданным индексом
     *
     * @param int|bool|string|null|float $key индекс искомого элемента
     *
     * @return bool
     */
    public function has(int|bool|string|null|float $key = null): bool
    {
        $output = (new KeySearcher($this->_data))->search($key);
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $result = $output->has();

        return $result;
    }

    /**
     * Выдаёт все элементы массива являющиеся массивами
     * Возвращает экземпляр с интерфейсом ArrayHandlerInterface
     *
     * @return Generator
     */
    public function pulling(): Generator
    {
        $keys = array_keys($this->_data);
        foreach ($keys as $key) {
            $nextArray = $this->pull($key);

            $isExists = !$nextArray->wasNotDefined();
            if ($isExists) {
                yield $key => $nextArray;
            }
        }
    }

    /**
     * Возвращает ArrayHandlerInterface для вложенного массива
     *
     * @param bool|int|string|null $key индекс элемента с массивом
     *
     * @return ArrayHandlerInterface
     */
    public function pull(
        int|bool|string|null|float $key = null
    ): ArrayHandlerInterface {
        $nested = $this->get($key);
        $isExists = $nested->wasDefined();
        $isArray = false;
        if ($isExists) {
            $isArray = $nested->type() === 'array';
        }
        $pulled = $this->arrayFactory::makeArrayHandlerWithoutArray();
        if ($isArray) {
            $pulled = $this
                ->arrayFactory
                ->makeArrayHandler($nested->asIs());
        }

        return $pulled;
    }

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->get($offset)->asIs();
    }

    /**
     * @throws ValueIsImmutableException
     */
    public function offsetSet($offset, $value): void
    {
        throw new ValueIsImmutableException(
            'Value of element is immutable.',
            -1
        );
    }

    /**
     * @throws ListIsImmutableException
     */
    public function offsetUnset($offset): void
    {
        throw new ListIsImmutableException(
            'List of elements is immutable.',
            -2
        );
    }
}
