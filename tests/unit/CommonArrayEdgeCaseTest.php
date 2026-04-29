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
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

final class CommonArrayEdgeCaseTest extends TestCase
{
    public function testIndexAccessWithUnsupportedIndexesReturnsSafeDefaults()
    {
        $factory = new ArrayFactory();
        $handler = $factory->makeCommonArray(['value' => 42]);

        self::assertFalse(isset($handler[new stdClass()]));
        self::assertFalse(isset($handler[[]]));
        self::assertFalse($handler[new stdClass()]->isReal());
        self::assertSame('', $handler[[]]->str());
    }

    public function testPhpArrayKeyCoercionBehaviourIsStable()
    {
        $factory = new ArrayFactory();
        $handler = $factory->makeCommonArray([
            0 => 'zero',
            1 => 'one',
            '' => 'empty-string',
        ]);

        // Check cast to zero
        self::assertSame('zero', $handler->get(0)->str());
        self::assertSame('zero', $handler->get('0')->str());

        // Check unsupported keys in PHP 7.4 array_key_exists()
        self::assertFalse($handler->get(-0.9)->isReal());
        self::assertFalse($handler->get(false)->isReal());
        self::assertFalse($handler->get(true)->isReal());
        self::assertFalse($handler->get(1.9)->isReal());

        // Check cast to empty string
        self::assertSame('empty-string', $handler->get(null)->str());
    }
}
