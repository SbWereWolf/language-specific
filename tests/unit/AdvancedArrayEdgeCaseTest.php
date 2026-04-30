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
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

final class AdvancedArrayEdgeCaseTest extends TestCase
{
    public function testPullReturnsDummyForExistingButNonArrayValues()
    {
        $handler = (new AdvancedArrayFactory())->makeAdvancedArray([
            'null' => null,
            'false' => false,
            'string' => 'hello',
            'object' => (object)['x' => 1],
        ]);

        self::assertTrue($handler->pull('null')->isDummy());
        self::assertTrue($handler->pull('false')->isDummy());
        self::assertTrue($handler->pull('string')->isDummy());
        self::assertTrue($handler->pull('object')->isDummy());
    }
}
