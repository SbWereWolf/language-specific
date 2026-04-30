<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 5/1/26, 1:08 AM
 */


use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

final class CommonValueDefaultBehaviorTest extends TestCase
{
    public function testDefaultReturnsNewDummyInstanceAndDoesNotMutateOriginal()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy();
        $withDefault = $value->setDefault('fallback');

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
        $withDefault = $value->setDefault('fallback');

        self::assertTrue($withDefault->isReal());
        self::assertSame('real', $withDefault->asIs());
        self::assertSame('real', $withDefault->str());
    }
}
