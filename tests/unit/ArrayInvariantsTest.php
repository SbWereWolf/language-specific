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
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

final class ArrayInvariantsTest extends TestCase
{
    public function testDeterministicRandomizedInvariants(): void
    {
        mt_srand(12345);
        $factory = new AdvancedArrayFactory();

        for ($i = 0; $i < 50; $i++) {
            $data = [];
            for ($j = 0; $j < 20; $j++) {
                $selector = mt_rand(0, 4);
                $value = match ($selector) {
                    0 => mt_rand(0, 1000),
                    1 => (string)mt_rand(0, 1000),
                    2 => (bool)mt_rand(0, 1),
                    3 => null,
                    default => [mt_rand(0, 10), mt_rand(0, 10)],
                };
                $data['k' . $j] = $value;
            }

            $handler = $factory->makeAdvancedArray($data);

            foreach ($data as $key => $value) {
                self::assertSame(array_key_exists($key, $data), $handler->has($key));
                self::assertSame(array_key_exists($key, $data), $handler->get($key)->isReal());
                self::assertSame(is_array($value), !$handler->pull($key)->isDummy());
            }

            if ($data === []) {
                self::assertFalse($handler->getAny()->isReal());
            } else {
                self::assertTrue($handler->getAny()->isReal());
            }
        }
    }
}
