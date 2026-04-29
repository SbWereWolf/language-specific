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

        $item = $handler->getAny();
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
            $handler->hasAny(),
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
        $data = [0 => 'first', 'next' => 20, null => 3.21,];

        $fabric = new ArrayFactory();
        $handler = $fabric->makeCommonArray($data);

        $nullExists = $handler->offsetExists(null);
        self::assertTrue(
            $nullExists,
            'CommonArray MUST contain index null'
        );

        $charZeroExists = $handler->offsetExists('0');
        self::assertTrue(
            $charZeroExists,
            'CommonArray DO MUST contain index "0"'
        );

        $first = $handler->offsetGet(0)->asIs();
        self::assertEquals(
            'first',
            $first,
            'Element with index 0 MUST BE "first"'
        );

        $valueAtIndex0 = $handler->offsetGet("0")->asIs();
        self::assertEquals(
            'first',
            $valueAtIndex0,
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

    /**
     * Проверяем доступ к краевым типам ключей
     *
     * @return void
     */
    public function testKeyNormalizationAndEmptyState()
    {
        $fabric = new ArrayFactory();
        $empty = $fabric->makeCommonArray([]);

        self::assertFalse(
            $empty->hasAny(),
            'Empty collection MUST NOT report any elements'
        );
        self::assertFalse(
            $empty->getAny()->isReal(),
            'getAny() for empty collection MUST return dummy value'
        );

        $handler = $fabric->makeCommonArray([
            '' => 'empty-string',
            0 => 'zero',
            1 => 'one',
            'nested' => null,
        ]);

        self::assertTrue(
            $handler->has(null),
            'Null key MUST resolve to empty string key'
        );
        self::assertSame(
            'empty-string',
            $handler->get(null)->str(),
            'Null key MUST return value of empty string key'
        );
        self::assertFalse(
            $handler->has(false),
            'False key MUST NOT resolve to integer zero in PHP 7.4 array_key_exists()'
        );
        self::assertFalse(
            $handler->get(false)->isReal(),
            'False key MUST return dummy value in PHP 7.4 array_key_exists()'
        );
        self::assertFalse(
            $handler->has(true),
            'True key MUST NOT resolve to integer one in PHP 7.4 array_key_exists()'
        );
        self::assertFalse(
            $handler->get(true)->isReal(),
            'True key MUST return dummy value in PHP 7.4 array_key_exists()'
        );
        self::assertFalse(
            $handler->has(0.9),
            'Float key MUST NOT resolve using PHP array key conversion rules in PHP 7.4 array_key_exists()'
        );
        self::assertFalse(
            $handler->get(0.9)->isReal(),
            'Float key MUST return dummy value in PHP 7.4 array_key_exists()'
        );
        self::assertTrue(
            $handler->has('nested'),
            'Existing key with null value MUST still be reported as existing'
        );
        self::assertTrue(
            $handler->get('nested')->isReal(),
            'Existing key with null value MUST be real value'
        );
        self::assertNull(
            $handler->get('nested')->asIs(),
            'Existing key with null value MUST return null as stored value'
        );
    }

    public function testOffsetSetThrowsExpectedImmutableExceptionCode(): void
    {
        $factory = new ArrayFactory();
        $handler = $factory->makeCommonArray([0 => 'first']);

        $this->expectException(ValueIsImmutableException::class);
        $this->expectExceptionMessage('Value of element is immutable.');
        $this->expectExceptionCode(-1);

        $handler->offsetSet(0, 0);
    }

    public function testOffsetUnsetThrowsExpectedImmutableExceptionCode(): void
    {
        $factory = new ArrayFactory();
        $handler = $factory->makeCommonArray([0 => 'first']);

        $this->expectException(ListIsImmutableException::class);
        $this->expectExceptionMessage('List of elements is immutable.');
        $this->expectExceptionCode(-2);

        $handler->offsetUnset(0);
    }
}
