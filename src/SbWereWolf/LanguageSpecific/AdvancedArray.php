<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 11:35 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific;

use Generator;
use SbWereWolf\LanguageSpecific\Collection\CommonArray;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactoryInterface;

/**
 * Class AdvancedArray
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
class AdvancedArray extends CommonArray implements
    AdvancedArrayInterface
{
    private bool $isDummy = true;
    private AdvancedArrayFactoryInterface $arrayFactory;

    /**
     * AdvancedArray constructor.
     * Принимает массив,
     *
     * @param array $data массив
     * @param CommonValueFactoryInterface $valueFactory фабрика для
     *                      создания экземпляров CommonValueInterface
     * @param AdvancedArrayFactoryInterface $arrayFactory фабрика для
     *                  создания новых экземпляров ArrayHandlerInterface
     * @param bool $isDummy флаг "является заглушкой для несуществующего
     *                      массива"
     */
    public function __construct(
        array $data,
        CommonValueFactoryInterface $valueFactory,
        AdvancedArrayFactoryInterface $arrayFactory,
        bool $isDummy,
    ) {
        parent::__construct($data, $valueFactory);

        $this->arrayFactory = $arrayFactory;

        if ($isDummy) {
            $this->isDummy = true;
        }
        if (!$isDummy) {
            $this->isDummy = false;
        }
    }

    /** @inheritDoc */
    public function isDummy(): bool
    {
        return $this->isDummy === true;
    }

    /** @inheritDoc */
    public function values(): Generator
    {
        $keys = array_keys($this->data);
        foreach ($keys as $key) {
            $value = $this->get($key);
            $isArray = $value->type() === 'array';

            if (!$isArray) {
                yield $key => $value;
            }
        }
    }

    /** @inheritDoc */
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

    /** @inheritDoc */
    public function arrays(): Generator
    {
        $keys = array_keys($this->data);
        foreach ($keys as $key) {
            $nextArray = $this->pull($key);

            $isReal = !$nextArray->isDummy();
            if ($isReal) {
                yield $key => $nextArray;
            }
        }
    }
}
