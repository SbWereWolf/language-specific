<?php

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
 */


namespace SbWereWolf\LanguageSpecific;

use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

/**
 * Class AdvancedArrayFactory
 *
 * @category Library
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT license
 * @link     https://github.com/SbWereWolf/language-specific
 */
final class AdvancedArrayFactory extends ArrayFactory implements
    AdvancedArrayFactoryInterface
{
    /** @inheritDoc */
    public function makeDummyAdvancedArray()
    {
        return new AdvancedArray(
            [],
            $this->valueFactory,
            $this,
            true
        );
    }

    /** @inheritDoc */
    public function makeAdvancedArray(
        $data
    ) {
        $data = $this->makeItProper($data);
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $handler = new AdvancedArray(
            $data,
            $this->valueFactory,
            $this,
            false
        );

        return $handler;
    }
}
