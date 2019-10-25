<?php
/**
 * LanguageSpecific
 * Copyright © 2019 Volkhin Nikolay
 * 26.10.2019, 3:02
 */

use LanguageFeatures\ArrayHandler;
use LanguageFeatures\ValueHandler;
use PHPUnit\Framework\TestCase;

class ArrayHandlerTest extends TestCase
{
    public function testNext()
    {
        $data = new ArrayHandler(['first', 'next', 'last',]);

        foreach ($data->next() as $item) {
            /* @var $item ValueHandler */
            self::assertTrue(!empty($item->asIs()), 'MUST NOT BE empty');
        }

        $item = $data->get();
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 'first',
            'MUST BE equal to first array element'
        );
    }

    public function testGet()
    {
        $data = new ArrayHandler(
            [0 => 'first',
                'next' => 20, 'last' => 3.01,]
        );

        $item = $data->get();
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 'first',
            'Rerurn value of simple get'
            . ' MUST BE equal to first array element'
        );

        $item = $data->get('no-exists');
        /* @var $item ValueHandler */
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of no-exists index MUST BE null'
        );

        $item = $data->get('next');
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 20,
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
        );

        $item = $data->get(99);
        /* @var $item ValueHandler */
        self::assertTrue(
            is_null($item->asIs()),
            'Return value of get() of no-exists index MUST BE null'
        );

        $item = $data->get(0);
        /* @var $item ValueHandler */
        self::assertTrue(
            $item->asIs() === 'first',
            'Return value of get() for exists index'
            . 'MUST BE equal the element value'
        );
    }

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
}
