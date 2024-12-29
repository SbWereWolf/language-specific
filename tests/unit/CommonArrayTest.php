<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 6:24 AM
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
use SbWereWolf\LanguageSpecific\Collection\CommonArray;
use SbWereWolf\LanguageSpecific\Collection\ListIsImmutableException;
use SbWereWolf\LanguageSpecific\Collection\ValueIsImmutableException;

/**
 * Class CommonArrayTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class CommonArrayTest extends TestCase
{
    /**
     * Проверяем конструктор CommonArray
     *
     * @return void
     */
    public function testMakeCommonArray()
    {
        $fabric = new ArrayFactory();

        $handler = $fabric->makeCommonArray(0);
        self::assertTrue(
            $handler instanceof CommonArray,
            'MUST BE possible create ArrayHandler from'
            . ' int'
        );

        $handler = $fabric->makeCommonArray(0.1);
        self::assertTrue(
            $handler instanceof CommonArray,
            'MUST BE possible create ArrayHandler from'
            . ' float'
        );

        $handler = $fabric->makeCommonArray(false);
        self::assertTrue(
            $handler instanceof CommonArray,
            'MUST BE possible create ArrayHandler from'
            . ' boolean'
        );

        $handler = $fabric->makeCommonArray('');
        self::assertTrue(
            $handler instanceof CommonArray,
            'MUST BE possible create ArrayHandler from'
            . ' string'
        );

        $handler = $fabric->makeCommonArray(null);
        self::assertTrue(
            $handler instanceof CommonArray,
            'MUST BE possible create ArrayHandler from'
            . ' NULL'
        );

        $handler = $fabric->makeCommonArray([]);
        self::assertTrue(
            $handler instanceof CommonArray,
            'MUST BE possible create ArrayHandler from'
            . ' array'
        );

        $handler = $fabric->makeCommonArray(new stdClass());
        self::assertTrue(
            $handler instanceof CommonArray,
            'MUST BE possible create ArrayHandler from'
            . ' object'
        );
    }

    /**
     * Проверяем метод CommonArray::get()
     *
     * @return void
     */
    public function testGet()
    {
        $data = [0 => 'first', 'next' => 20, 'last' => 3.01,];

        $fabric = new ArrayFactory();
        $handler = $fabric->makeCommonArray($data);

        $item = $handler->get();
        self::assertTrue(
            $item->asIs() === 'first',
            'Return value of simple get'
            . ' MUST BE equal to first array element'
        );

        $item = $handler->get('no-exists');
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of non existence index'
            . ' MUST BE null'
        );
        self::assertFalse(
            $item->isReal(),
            'Return value of isReal() of non existence index'
            . ' MUST BE false'
        );

        $item = $handler->get('next');
        self::assertTrue(
            $item->asIs() === 20,
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
        );

        $item = $handler->get(99);
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of non existence index'
            . ' MUST BE null'
        );
        self::assertFalse(
            $item->isReal(),
            'Return value of isReal() of non existence index'
            . ' MUST BE false'
        );

        $item = $handler->get(0);
        self::assertTrue(
            $item->asIs() === 'first',
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
        );
    }

    /**
     * Проверяем метод CommonArray::has()
     *
     * @return void
     */
    public function testHas()
    {
        $data = [0 => 'first', 'next' => 20, null => 3.01,];

        $fabric = new ArrayFactory();
        $handler = $fabric->makeCommonArray($data);

        self::assertTrue(
            $handler->has(),
            'CommonArray MUST contain any index'
        );
        self::assertTrue(
            $handler->has(0),
            'CommonArray MUST contain index 0'
        );
        self::assertTrue(
            $handler->has('next'),
            'CommonArray MUST contain index `next`'
        );
        self::assertTrue(
            $handler->has(null),
            'CommonArray MUST contain index with value null'
        );
        self::assertFalse(
            $handler->has('not-exists'),
            'CommonArray MUST NOT contain index `not-exists`'
        );
    }

    /**
     * Проверяем реализацию ArrayAccess
     *
     * @return void
     */
    public function testArrayAccessAbilities()
    {
        $data = [0 => 'first', 'next' => 20, null => 3.01,];

        $fabric = new ArrayFactory();
        $handler = $fabric->makeCommonArray($data);

        $exists = $handler->offsetExists(null);
        self::assertTrue(
            $exists,
            'CommonArray MUST contain index null'
        );

        $notExists = $handler->offsetExists('0');
        self::assertFalse(
            $notExists,
            'CommonArray DO NOT MUST contain index "0"'
        );

        $first = $handler->offsetGet(0);
        self::assertEquals(
            'first',
            $first,
            'Element with index 0 MUST BE "first"'
        );

        $null = $handler->offsetGet("0");
        self::assertEquals(
            null,
            $null,
            'For not exists index CommonArray MUST return NULL'
        );

        $isProper = false;
        try {
            $handler->offsetSet(0, 0);
        } catch (Throwable $e) {
            $isProper = $e instanceof ValueIsImmutableException;
        }
        self::assertTrue(
            $isProper,
            'offsetSet MUST throw ValueIsImmutableException'
        );

        $isProper = false;
        try {
            $handler->offsetUnset(0);
        } catch (Throwable $e) {
            $isProper = $e instanceof ListIsImmutableException;
        }
        self::assertTrue(
            $isProper,
            'offsetUnset MUST throw ListIsImmutableException'
        );
    }
}
