<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 3/30/26, 8:30 PM
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

final class CommonValueDefaultBehaviorTest extends TestCase
{
    public function testDefaultMutatesDummyInstanceState(): void
    {
        $value = CommonValueFactory::makeCommonValueAsDummy();

        self::assertSame(
            'fallback',
            $value->default('fallback')->str()
        );

        // The default value is saved after one use
        self::assertSame('fallback', $value->str());

        // the original value is still dummy
        self::assertFalse($value->isReal());
    }
}
