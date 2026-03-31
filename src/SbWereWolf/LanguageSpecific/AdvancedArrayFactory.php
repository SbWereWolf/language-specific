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
final readonly class AdvancedArrayFactory extends ArrayFactory implements
    AdvancedArrayFactoryInterface
{
    /** @inheritDoc */
    public function makeDummyAdvancedArray(): AdvancedArrayInterface
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
        mixed $data,
    ): AdvancedArrayInterface {
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
