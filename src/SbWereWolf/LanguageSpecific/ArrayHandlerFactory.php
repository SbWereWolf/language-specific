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

class ArrayHandlerFactory implements ArrayHandlerFactoryInterface
{
    private ValueHandlerFactoryInterface $factory;

    public function __construct(ValueHandlerFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function
    makeArrayHandlerWithoutArray(): ArrayHandlerInterface
    {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $handler = new ArrayHandler([], null, null, true);

        return $handler;
    }

    public function makeArrayHandler(
        array $values
    ): ArrayHandlerInterface {
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $handler = new ArrayHandler($values, $this->factory, $this);

        return $handler;
    }
}