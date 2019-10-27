<?php
/**
 * PHP version 5.6
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2019 Volkhin Nikolay
 * 27.10.2019, 5:16
 */

use LanguageSpecific\ArrayHandler;
use LanguageSpecific\ValueHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandlerTest extends TestCase
{
    /**
     * Проверяем конструктор ArrayHandler
     *
     * @return void
     */
    public function testConstructor()
    {
        $handler = new ArrayHandler(0);
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' int'
        );

        $handler = new ArrayHandler(0.1);
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' float'
        );

        $handler = new ArrayHandler(false);
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' boolean'
        );

        $handler = new ArrayHandler(' ');
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' string'
        );

        $handler = new ArrayHandler(null);
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' NULL'
        );

        $handler = new ArrayHandler([]);
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' array'
        );
    }

    /**
     * Проверяем метод ArrayHandler::next()
     *
     * @return void
     */
    public function testNext()
    {
        $data = new ArrayHandler(['first', 'next', 'last',]);

        $index = 0;
        foreach ($data->next() as $item) {
            /* @var $item ValueHandler */
            self::assertTrue(!empty($item->asIs()), 'MUST NOT BE empty');
            $index++;
        }

        self::assertTrue(
            $index === 3,
            'All of array elements MUST been iterated'
        );
        $item = $data->get();
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 'first',
            'MUST BE equal to first array element'
        );
    }

    /**
     * Проверяем метод ArrayHandler::get()
     *
     * @return void
     */
    public function testGet()
    {
        $data = new ArrayHandler(
            [0 => 'first', 'next' => 20, 'last' => 3.01,]
        );

        $item = $data->get();
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 'first',
            'Return value of simple get'
            . ' MUST BE equal to first array element'
        );

        $item = $data->get('no-exists');
        /* @var $item ValueHandler */
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of non existence index MUST BE null'
        );
        self::assertFalse(
            $item->has(),
            'Return value of has() of non existence index MUST BE false'
        );

        $item = $data->get('next');
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 20,
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
        );

        $item = $data->get(99);
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of non existence index MUST BE null'
        );
        self::assertFalse(
            $item->has(),
            'Return value of has() of non existence index MUST BE false'
        );

        $item = $data->get(0);
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 'first',
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
        );
    }

    /**
     * Проверяем метод ArrayHandler::simplify()
     *
     * @return void
     */
    public function testSimplify()
    {
        $data = new ArrayHandler([0, [1, 2], [[3, 4], [5, 6]], null,]);

        $data->simplify();
        $nested = 0;
        foreach ($data->next() as $item) {
            if (is_array($item->asIs())) {
                $nested++;
            }
        }
        self::assertEquals(
            1,
            $nested,
            'Nested array after simplify MUST BE only one'
        );
    }

    /**
     * Проверяем метод ArrayHandler::has()
     *
     * @return void
     */
    public function testHas()
    {
        $data = new ArrayHandler(
            [0 => 'first', 'next' => 20, null => 3.01,]
        );

        self::assertTrue(
            $data->has(),
            'ArrayHandler MUST contain any index'
        );
        self::assertTrue(
            $data->has(0),
            'ArrayHandler MUST contain index 0'
        );
        self::assertTrue(
            $data->has('next'),
            'ArrayHandler MUST contain index `next`'
        );
        self::assertTrue(
            $data->has(null),
            'ArrayHandler MUST contain index with value null'
        );
        self::assertFalse(
            $data->has('not-exists'),
            'ArrayHandler MUST NOT contain index `not-exists`'
        );
    }
}
