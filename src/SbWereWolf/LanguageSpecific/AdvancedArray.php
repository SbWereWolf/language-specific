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


use Generator;

/**
 * Class AdvancedArray
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class AdvancedArray extends CommonArray
    implements AdvancedArrayInterface
{
    private AdvancedArrayFactory $arrayFactory;

    /**
     * AdvancedArray constructor.
     * Принимает массив,
     * либо значение которое можно привести к массиву
     *
     * @param array $data массив
     * @param CommonValueFactoryInterface|null $valueFactory
     *  фабрика для создания экземпляров CommonValueInterface
     * @param AdvancedArrayFactoryInterface|null $arrayFactory
     * фабрика для создания новых экземпляров ArrayHandlerInterface
     * @param bool $isDummy
     *          флаг "является заглушкой для несуществующего массива"
     */
    public function __construct(
        mixed $data,
        CommonValueFactoryInterface|null $valueFactory = null,
        AdvancedArrayFactoryInterface|null $arrayFactory = null,
        bool $isDummy = false,
    ) {
        parent::__construct($data, $valueFactory);

        if (is_null($arrayFactory)) {
            $this->arrayFactory =
                new AdvancedArrayFactory($this->valueFactory);
        }
        if ($arrayFactory instanceof AdvancedArrayFactoryInterface) {
            $this->arrayFactory = $arrayFactory;
        }

        if ($isDummy) {
            $this->_data = [];
            $this->riseIsDummy();
        }
        if (!$isDummy) {
            $this->_data = array_replace([], $this->_data);
            $this->dropIsDummy();
        }
    }

    /* @inheritDoc */
    public function values(): Generator
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

    /* @inheritDoc */
    public function pull(
        int|bool|string|null|float $key = null
    ): AdvancedArrayInterface {
        $nested = $this->get($key);
        $isExists = $nested->isReal();
        $isArray = false;
        if ($isExists) {
            $isArray = $nested->type() === 'array';
        }
        $pulled = $this->arrayFactory::makeDummyAdvancedArray();
        if ($isArray) {
            $pulled = $this
                ->arrayFactory
                ->makeAdvancedArray($nested->asIs());
        }

        return $pulled;
    }

    /* @inheritDoc */
    public function arrays(): Generator
    {
        $keys = array_keys($this->_data);
        foreach ($keys as $key) {
            $nextArray = $this->pull($key);

            $isReal = !$nextArray->isDummy();
            if ($isReal) {
                yield $key => $nextArray;
            }
        }
    }
}
