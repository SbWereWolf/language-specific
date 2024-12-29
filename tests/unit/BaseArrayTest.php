<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 8:05 AM
 */

declare(strict_types=1);

/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 5:16 AM
 */

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;
use SbWereWolf\LanguageSpecific\Collection\BaseArray;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Class BaseArrayTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class BaseArrayTest extends TestCase
{
    /**
     * Проверяем конструктор BaseArray
     *
     * @return void
     */
    public function testMakeBaseArray()
    {
        $fabric = new ArrayFactory();

        $handler = $fabric->makeBaseArray(0);
        self::assertTrue(
            $handler instanceof BaseArray,
            'MUST BE possible create ArrayHandler from'
            . ' int'
        );

        $handler = $fabric->makeBaseArray(0.1);
        self::assertTrue(
            $handler instanceof BaseArray,
            'MUST BE possible create ArrayHandler from'
            . ' float'
        );

        $handler = $fabric->makeBaseArray(false);
        self::assertTrue(
            $handler instanceof BaseArray,
            'MUST BE possible create ArrayHandler from'
            . ' boolean'
        );

        $handler = $fabric->makeBaseArray('');
        self::assertTrue(
            $handler instanceof BaseArray,
            'MUST BE possible create ArrayHandler from'
            . ' string'
        );

        $handler = $fabric->makeBaseArray(null);
        self::assertTrue(
            $handler instanceof BaseArray,
            'MUST BE possible create ArrayHandler from'
            . ' NULL'
        );

        $handler = $fabric->makeBaseArray([]);
        self::assertTrue(
            $handler instanceof BaseArray,
            'MUST BE possible create ArrayHandler from'
            . ' array'
        );

        $handler = $fabric->makeBaseArray(new stdClass());
        self::assertTrue(
            $handler instanceof BaseArray,
            'MUST BE possible create ArrayHandler from'
            . ' object'
        );
    }

    /**
     * Проверяем BaseArray::raw()
     *
     * @return void
     */
    public function testRaw()
    {
        $fabric = new ArrayFactory();
        $handler = $fabric->makeBaseArray([
            -1 => 0,
            '0' => 1,
            null => 3,
            true => false
        ]);

        $content = $handler->raw();
        self::assertEmpty(
            array_diff($content, [
                -1 => 0,
                '0' => 1,
                null => 3,
                true => false
            ]),
            'MUST BE exact'
            . ' [-1 => 0, "0" => 1, null => 3, true => false]'
        );
    }

    /**
     * Проверяем реализацию JsonSerializable
     *
     * @return void
     */
    public function testJsonSerializeAbilities()
    {
        $fabric = new ArrayFactory();
        $handler = $fabric->makeBaseArray([
            -1 => 0,
            '0' => 1,
            null => 3,
            true => false
        ]);

        $content = $handler->jsonSerialize();
        self::assertEmpty(
            array_diff($content, [
                -1 => 0,
                '0' => 1,
                null => 3,
                true => false
            ]),
            'MUST BE exact'
            . ' [-1 => 0, "0" => 1, null => 3, true => false]'
        );
    }

    /**
     * Проверяем реализацию Iterator
     *
     * @return void
     */
    public function testIteratorAbilities()
    {
        $fabric = new ArrayFactory();
        $handler = $fabric->makeBaseArray([
            -1 => 0,
            '0' => 1,
            null => 3,
            true => false
        ]);

        $key = $handler->key();
        self::assertEquals(-1, $key, 'First index should be -1');
        /* @var CommonValueInterface $value */
        $value = $handler->current();
        self::assertEquals(
            0,
            $value->asIs(),
            'First element should be 0'
        );

        $handler->next();
        $key = $handler->key();
        self::assertEquals('0', $key, 'Second index should be "0"');
        /* @var CommonValueInterface $value */
        $value = $handler->current();
        self::assertEquals(
            1,
            $value->asIs(),
            'Second element should be 1'
        );

        $isValid = $handler->valid();
        self::assertTrue(
            $isValid,
            'Current element should be valid'
        );

        $handler->next();
        $handler->next();
        $hasMore = $handler->next();

        self::assertFalse(
            $hasMore,
            'Collection have only 4 elements,'
            . ' after 4 next() internal pointer MUST point to null'
        );

        $handler->rewind();
        $key = $handler->key();
        self::assertEquals(
            -1,
            $key,
            'After rewind current element index should be -1'
        );
        /* @var CommonValueInterface $value */
        $value = $handler->current();
        self::assertEquals(
            0,
            $value->asIs(),
            'After rewind current element value should be 0'
        );
    }
}
