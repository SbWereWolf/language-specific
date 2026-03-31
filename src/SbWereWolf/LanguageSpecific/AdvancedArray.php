<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/1/26, 4:31 AM
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
final class AdvancedArray extends CommonArray implements
    AdvancedArrayInterface
{
    private bool $isDummy;
    private AdvancedArrayFactoryInterface $arrayFactory;

    /**
     * AdvancedArray constructor.
     * Принимает массив,
     *
     * @param array<array-key, mixed> $data массив
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
        $this->isDummy = $isDummy;
    }

    /** @inheritDoc */
    public function isDummy(): bool
    {
        return $this->isDummy;
    }

    /** @inheritDoc */
    public function values(): Generator
    {
        foreach ($this->data as $key => $value) {
            if (!is_array($value)) {
                yield
                $key => $this->valueFactory::makeCommonValue($value);
            }
        }
    }

    /** @inheritDoc */
    public function pull(
        int|bool|string|null|float $key = null
    ): AdvancedArrayInterface {
        if ($key === null) {
            foreach ($this->data as $value) {
                if (is_array($value)) {
                    return
                        $this->arrayFactory->makeAdvancedArray($value);
                }
            }

            return $this->arrayFactory->makeDummyAdvancedArray();
        }

        if (
            !array_key_exists($key, $this->data)
            || !is_array($this->data[$key])
        ) {
            return $this->arrayFactory->makeDummyAdvancedArray();
        }

        return
            $this->arrayFactory->makeAdvancedArray($this->data[$key]);
    }

    /** @inheritDoc */
    public function arrays(): Generator
    {
        foreach ($this->data as $key => $value) {
            if (is_array($value)) {
                yield
                $key => $this->arrayFactory->makeAdvancedArray($value);
            }
        }
    }
}
