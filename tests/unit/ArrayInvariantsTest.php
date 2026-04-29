<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 4/29/26, 8:46 PM
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
                switch ($selector) {
                    case 0:
                        $value = mt_rand(0, 1000);
                        break;
                    case 1:
                        $value = (string)mt_rand(0, 1000);
                        break;
                    case 2:
                        $value = (bool)mt_rand(0, 1);
                        break;
                    case 3:
                        $value = null;
                        break;
                    default:
                        $value = [mt_rand(0, 10), mt_rand(0, 10)];
                        break;
                }
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
