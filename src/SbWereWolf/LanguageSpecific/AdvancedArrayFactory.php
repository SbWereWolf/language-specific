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

class AdvancedArrayFactory implements AdvancedArrayFactoryInterface
{
    private CommonValueFactoryInterface $factory;

    public function __construct(CommonValueFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function
    makeDummyAdvancedArray(): AdvancedArrayInterface
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $handler = new AdvancedArray([], null, null, true);

        return $handler;
    }

    public function makeAdvancedArray(
        array $values
    ): AdvancedArrayInterface {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $handler = new AdvancedArray($values, $this->factory, $this);

        return $handler;
    }
}