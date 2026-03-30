<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 3/31/26, 3:31 AM
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

final class CommonArrayEdgeCaseTest extends TestCase
{
    public function testIndexAccessWithUnsupportedIndexesReturnsSafeDefaults(): void
    {
        $handler = new ArrayFactory()->makeCommonArray(['value' => 42]);

        self::assertFalse(isset($handler[new stdClass()]));
        self::assertFalse(isset($handler[[]]));
        self::assertFalse($handler[new stdClass()]->isReal());
        self::assertSame('', $handler[[]]->str());
    }

    public function testPhpArrayKeyCoercionBehaviourIsStable(): void
    {
        $handler = new ArrayFactory()->makeCommonArray([
            0 => 'zero',
            1 => 'one',
            '' => 'empty-string',
        ]);

        // Check cast to zero
        self::assertSame('zero', $handler->get(0)->str());
        self::assertSame('zero', $handler->get(-0.9)->str());
        self::assertSame('zero', $handler->get('0')->str());
        self::assertSame('zero', $handler->get(false)->str());

        // Check cast to one
        self::assertSame('one', $handler->get(true)->str());
        self::assertSame('one', $handler->get(1.9)->str());

        // Check cast to empty string
        self::assertSame('empty-string', $handler->get(null)->str());
    }
}
