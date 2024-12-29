<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/27/24, 10:03 AM
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
use SbWereWolf\LanguageSpecific\AdvancedArray;
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;
use SbWereWolf\LanguageSpecific\AdvancedArrayInterface;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Class ArrayHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class AdvancedArrayTest extends TestCase
{
    /**
     * Проверяем конструктор AdvancedArray
     *
     * @return void
     */
    public function testMakeAdvancedArray()
    {
        $fabric = new AdvancedArrayFactory();

        $handler = $fabric->makeAdvancedArray(0);
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create ArrayHandler from'
            . ' int'
        );

        $handler = $fabric->makeAdvancedArray(0.1);
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create ArrayHandler from'
            . ' float'
        );

        $handler = $fabric->makeAdvancedArray(false);
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create ArrayHandler from'
            . ' boolean'
        );

        $handler = $fabric->makeAdvancedArray('');
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create ArrayHandler from'
            . ' string'
        );

        $handler = $fabric->makeAdvancedArray(null);
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create ArrayHandler from'
            . ' NULL'
        );

        $handler = $fabric->makeAdvancedArray([]);
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create ArrayHandler from'
            . ' array'
        );

        $handler = $fabric->makeAdvancedArray(new stdClass());
        self::assertTrue(
            $handler instanceof AdvancedArray,
            'MUST BE possible create ArrayHandler from'
            . ' object'
        );
    }
    /**
     * Проверяем метод AdvancedArray::arrays()
     *
     * @return void
     */
    public function testValues()
    {
        $last = ['1', '2', '3',];
        $data = [
            ['A', 'B', 'C',],
            'first',
            'next',
            'last',
            $last
        ];

        $fabric = new AdvancedArrayFactory(new CommonValueFactory());
        $handler = $fabric->makeAdvancedArray($data);

        $index = 0;
        $item = CommonValueFactory::makeCommonValueAsDummy();
        foreach ($handler->values() as $item) {
            /* @var $item CommonValueInterface */
            self::assertTrue(
                $item->isReal(),
                'Value item MUST BE real'
            );
            $index++;
        }

        self::assertTrue(
            $index === 3,
            'Three elements of array MUST been iterated'
        );

        self::assertEquals(
            'last',
            $item->asIs(),
            'Recent element MUST BE "last"'
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

    /**
     * Проверяем метод AdvancedArray::arrays()
     *
     * @return void
     */
    public function testArrays()
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
                'Pulled item MUST BE real'
            );
            $index++;
        }

        self::assertTrue(
            $index === 3,
            'Three elements of array MUST been iterated'
        );

        self::assertEmpty(
            array_diff($last, $item->raw()),
            'Pulled item MUST BE same as last array element'
        );
    }
}
