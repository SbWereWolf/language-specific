<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/30/24, 8:46 AM
 */

declare(strict_types=1);

namespace SbWereWolf\LanguageSpecific;

use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

class AdvancedArrayFactory
    extends ArrayFactory
    implements AdvancedArrayFactoryInterface
{
    /* @inheritDoc */
    public static function
    makeDummyAdvancedArray(): AdvancedArrayInterface
    {
        $factory = new CommonValueFactory();
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $handler = new AdvancedArray(
            [],
            $factory,
            new AdvancedArrayFactory($factory),
            true
        );

        return $handler;
    }

    /* @inheritDoc */
    public function makeAdvancedArray(
        mixed $data,
    ): AdvancedArrayInterface {
        $data = $this->makeItProper($data);
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $handler = new AdvancedArray(
            $data, $this->valueFactory, $this, false
        );

        return $handler;
    }
}