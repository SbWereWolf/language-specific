<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2025 Volkhin Nikolay
 * 1/12/25, 5:14 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific;

use Generator;
use SbWereWolf\LanguageSpecific\Collection\CommonArray;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactoryInterface;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

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
        foreach ($this as $key => $val) {
            /** @var CommonValueInterface $val */
            $isArray = $val->type() === 'array';
            if (!$isArray) {
                yield $key => $val;
            }
        }
    }

    /** @inheritDoc */
    public function pull(
        int|bool|string|null|float $key = null
    ): AdvancedArrayInterface {
        $pulled = $this->arrayFactory::makeDummyAdvancedArray();

        $isNullKey = is_null($key);
        if ($isNullKey && $this->arrays()->valid()) {
            $pulled = $this->arrays()->current();
        }

        $nested = $this->valueFactory::makeCommonValueAsDummy();
        $isReal = false;
        if (!$isNullKey) {
            $nested = $this->get($key);
            $isReal = $nested->isReal();
        }
        $isArray = false;
        if ($isReal) {
            $isArray = $nested->type() === 'array';
        }
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
        foreach ($this as $key => $val) {
            /** @var CommonValueInterface $val */
            $isArray = $val->type() === 'array';
            if ($isArray) {
                $nextArray = $this->arrayFactory
                    ->makeAdvancedArray($val->asIs());

                yield $key => $nextArray;
            }
        }
    }
}
