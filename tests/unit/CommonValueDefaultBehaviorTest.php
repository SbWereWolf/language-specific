<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/30/26, 1:00 AM
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

final class CommonValueDefaultBehaviorTest extends TestCase
{
    public function testDefaultReturnsNewDummyInstanceAndDoesNotMutateOriginal()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy();
        $withDefault = $value->default('fallback');

        self::assertFalse($value->isReal());
        self::assertNull($value->asIs());
        self::assertSame('', $value->str());

        self::assertFalse($withDefault->isReal());
        self::assertSame('fallback', $withDefault->asIs());
        self::assertSame('fallback', $withDefault->str());
    }

    public function testDefaultOnRealValueKeepsOriginalValue()
    {
        $value = CommonValueFactory::makeCommonValue('real');
        $withDefault = $value->default('fallback');

        self::assertTrue($withDefault->isReal());
        self::assertSame('real', $withDefault->asIs());
        self::assertSame('real', $withDefault->str());
    }
}
