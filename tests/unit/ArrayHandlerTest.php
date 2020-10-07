<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2020 Volkhin Nikolay
 * 08.10.2020, 3:48
 */

/**
 * PHP version 5.6
 *
 * @category Test
 */

use LanguageSpecific\ArrayHandler;
use LanguageSpecific\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/LICENSE
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
        $handler = new ArrayHandler(0, new Factory());
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' int'
        );

        $handler = new ArrayHandler(0.1, new Factory());
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' float'
        );

        $handler = new ArrayHandler(false, new Factory());
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' boolean'
        );

        $handler = new ArrayHandler(' ', new Factory());
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' string'
        );

        $handler = new ArrayHandler(null, new Factory());
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' NULL'
        );

        $handler = new ArrayHandler([], new Factory());
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' array'
        );

        $handler = new ArrayHandler(new ArrayHandler());
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' object'
        );
    }

    /**
     * Проверяем метод ArrayHandler::pulling()
     *
     * @return void
     */
    public function testPulling()
    {
        $last = ['1', '2', '3',];
        $data = new ArrayHandler([['first', 'next', 'last',],
            ['A', 'B', 'C',], $last]);

        $index = 0;
        $item = new ArrayHandler();
        foreach ($data->pulling() as $item) {
            self::assertFalse($item->isUndefined(),
                'Pulled item MUST BE defined');
            $index++;
        }

        self::assertTrue(
            $index === 3,
            'All of array elements MUST been iterated'
        );

        self::assertTrue(
            empty(array_diff($last, $item->raw())),
            'Pulled item MUST BE same as last array element'
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
            , new Factory());

        $item = $data->get();
        self::assertTrue(
            $item->asIs() === 'first',
            'Return value of simple get'
            . ' MUST BE equal to first array element'
        );

        $item = $data->get('no-exists');
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of non existence index'
            . ' MUST BE null'
        );
        self::assertFalse(
            $item->has(),
            'Return value of has() of non existence index'
            . ' MUST BE false'
        );

        $item = $data->get('next');
        self::assertTrue(
            $item->asIs() === 20,
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
        );

        $item = $data->get(99);
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of non existence index'
            . ' MUST BE null'
        );
        self::assertFalse(
            $item->has(),
            'Return value of has() of non existence index'
            . ' MUST BE false'
        );

        $item = $data->get(0);
        self::assertTrue(
            $item->asIs() === 'first',
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
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


    /**
     * Проверяем метод ArrayHandler::pull()
     *
     * @return void
     */
    public function testPull()
    {
        $level4 = [-4 =>
            ['over' => ['and' => ['over' => ['again' => [true]]]]]];
        $level3 = [-3 => $level4, 'some' => 'other',];
        $level2 = [-2 => $level3];
        $level1 = [-1 => $level2, 'other' => ['content'], 'any'];
        $level0 = [$level1];
        $data = new ArrayHandler($level0);

        self::assertTrue(
            is_array($data->pull()->get()->asIs()),
            'First pull MUST return array'
        );
        self::assertTrue(
            is_array($data->pull()->pull(-1)->get()->asIs()),
            'Pull of key `-1` MUST return array'
        );
        self::assertTrue(
            $data->pull()->pull('other')
                ->get()->str() === 'content',
            'Pull of key `other` MUST return array'
        );
        self::assertTrue(
            $data->pull()->pull(-1)->pull()->get('some')
                ->str() === 'other',
            'Index `some` MUST BE equal `other`'
        );
        self::assertTrue(
            $data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull(-5)
                ->isUndefined(),
            'pull() of non existing index (`-5`) MUST'
            . ' return undefined ArrayHandler'
        );
        self::assertFalse(
            $data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->isUndefined(),
            'pull() existing index (`again`) MUST'
            . ' return not undefined ArrayHandler (defined array)'
        );
        self::assertTrue(
            $data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->get()->bool(),
            'pull(`again`) MUST contain array with value'
            . ' of true'
        );
    }
}
