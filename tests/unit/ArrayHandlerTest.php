<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 9:40 PM
 */

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\AdvancedArray;
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;
use SbWereWolf\LanguageSpecific\AdvancedArrayInterface;
use SbWereWolf\LanguageSpecific\CommonValueFactory;

/**
 * Class ArrayHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ArrayHandlerTest extends TestCase
{
    /**
     * Проверяем конструктор AdvancedArray
     *
     * @return void
     */
    public function testConstructor()
    {
        $fabric = new AdvancedArrayFactory(new CommonValueFactory());
        $handler = $fabric->makeAdvancedArray([]);
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create AdvancedArray from'
            . ' array'
        );
    }

    /**
     * Проверяем метод AdvancedArray::pulling()
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

        $fabric = new AdvancedArrayFactory(new CommonValueFactory());
        $handler = $fabric->makeAdvancedArray($data);

        $index = 0;
        $item = $fabric::makeDummyAdvancedArray();
        foreach ($handler->arrays() as $item) {
            /* @var $item AdvancedArrayInterface */
            self::assertFalse(
                $item->isDummy(),
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
     * Проверяем метод AdvancedArray::get()
     *
     * @return void
     */
    public function testGet()
    {
        $data = [0 => 'first', 'next' => 20, 'last' => 3.01,];

        $fabric = new AdvancedArrayFactory(new CommonValueFactory());
        $handler = $fabric->makeAdvancedArray($data);

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
     * Проверяем метод AdvancedArray::isReal()
     *
     * @return void
     */
    public function testIsReal()
    {
        $data = [0 => 'first', 'next' => 20, null => 3.01,];

        $fabric = new AdvancedArrayFactory(new CommonValueFactory());
        $handler = $fabric->makeAdvancedArray($data);

        self::assertTrue(
            $handler->has(),
            'AdvancedArray MUST contain any index'
        );
        self::assertTrue(
            $handler->has(0),
            'AdvancedArray MUST contain index 0'
        );
        self::assertTrue(
            $handler->has('next'),
            'AdvancedArray MUST contain index `next`'
        );
        self::assertTrue(
            $handler->has(null),
            'AdvancedArray MUST contain index with value null'
        );
        self::assertFalse(
            $handler->has('not-exists'),
            'AdvancedArray MUST NOT contain index `not-exists`'
        );
    }

    /**
     * Проверяем метод AdvancedArray::pull()
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

        $fabric = new AdvancedArrayFactory(new CommonValueFactory());
        $handler = $fabric->makeAdvancedArray($level0);

        self::assertTrue(
            $handler->pull()->isDummy() === false,
            'First pull MUST return real array'
        );
        self::assertTrue(
            $handler->pull()->pull(-1)->isDummy() === false,
            'Pull of key `-1` MUST return real array'
        );
        self::assertTrue(
            $handler->pull()->pull('other')->isDummy() === false,
            'Pull of key `other` MUST return real array'
        );
        self::assertTrue(
            $handler->pull()->pull(-1)->pull()->get('some')
                ->str() === 'other',
            'Element value with index `some` MUST BE `other`'
        );
        self::assertTrue(
            $handler->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull(-5)
                ->isDummy(),
            'pull() of non existing index (`-5`) MUST'
            . ' return dummy AdvancedArray'
        );
        self::assertFalse(
            $handler->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->isDummy(),
            'pull() existing index (`again`) MUST'
            . ' return real AdvancedArray (value is not dummy)'
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
