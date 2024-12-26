<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 7:57 AM
 */

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\ArrayHandler;
use SbWereWolf\LanguageSpecific\ArrayHandlerFactory;
use SbWereWolf\LanguageSpecific\ArrayHandlerInterface;
use SbWereWolf\LanguageSpecific\ValueHandlerFactory;

/**
 * Class ArrayHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
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
        $fabric = new ArrayHandlerFactory(new ValueHandlerFactory());
        $handler = $fabric->makeArrayHandler([]);
        self::assertTrue(
            $handler instanceof ArrayHandler,
            'MUST BE possible create ArrayHandler from'
            . ' array'
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
        $data = [
            ['first', 'next', 'last',],
            ['A', 'B', 'C',],
            $last
        ];

        $fabric = new ArrayHandlerFactory(new ValueHandlerFactory());
        $handler = $fabric->makeArrayHandler($data);

        $index = 0;
        $item = $fabric::makeArrayHandlerWithoutArray();
        foreach ($handler->pulling() as $item) {
            /* @var $item ArrayHandlerInterface */
            self::assertFalse(
                $item->wasNotDefined(),
                'Pulled item MUST BE defined'
            );
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
        $data = [0 => 'first', 'next' => 20, 'last' => 3.01,];

        $fabric = new ArrayHandlerFactory(new ValueHandlerFactory());
        $handler = $fabric->makeArrayHandler($data);

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
            $item->wasDefined(),
            'Return value of has() of non existence index'
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
            $item->wasDefined(),
            'Return value of has() of non existence index'
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
     * Проверяем метод ArrayHandler::has()
     *
     * @return void
     */
    public function testHas()
    {
        $data = [0 => 'first', 'next' => 20, null => 3.01,];

        $fabric = new ArrayHandlerFactory(new ValueHandlerFactory());
        $handler = $fabric->makeArrayHandler($data);

        self::assertTrue(
            $handler->has(),
            'ArrayHandler MUST contain any index'
        );
        self::assertTrue(
            $handler->has(0),
            'ArrayHandler MUST contain index 0'
        );
        self::assertTrue(
            $handler->has('next'),
            'ArrayHandler MUST contain index `next`'
        );
        self::assertTrue(
            $handler->has(null),
            'ArrayHandler MUST contain index with value null'
        );
        self::assertFalse(
            $handler->has('not-exists'),
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
        $level4 = [
            -4 =>
                ['over' => ['and' => ['over' => ['again' => [true]]]]]
        ];
        $level3 = [-3 => $level4, 'some' => 'other',];
        $level2 = [-2 => $level3];
        $level1 = [-1 => $level2, 'other' => ['content'], 'any'];
        $level0 = [$level1];

        $fabric = new ArrayHandlerFactory(new ValueHandlerFactory());
        $handler = $fabric->makeArrayHandler($level0);

        self::assertTrue(
            is_array($handler->pull()->get()->asIs()),
            'First pull MUST return array'
        );
        self::assertTrue(
            is_array($handler->pull()->pull(-1)->get()->asIs()),
            'Pull of key `-1` MUST return array'
        );
        self::assertTrue(
            $handler->pull()->pull('other')
                ->get()->str() === 'content',
            'Pull of key `other` MUST return array'
        );
        self::assertTrue(
            $handler->pull()->pull(-1)->pull()->get('some')
                ->str() === 'other',
            'Index `some` MUST BE equal `other`'
        );
        self::assertTrue(
            $handler->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull(-5)
                ->wasNotDefined(),
            'pull() of non existing index (`-5`) MUST'
            . ' return undefined ArrayHandler'
        );
        self::assertFalse(
            $handler->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->wasNotDefined(),
            'pull() existing index (`again`) MUST'
            . ' return not undefined ArrayHandler (defined array)'
        );
        self::assertTrue(
            $handler->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->get()->bool(),
            'pull(`again`) MUST contain array with value'
            . ' of true'
        );
    }
}
