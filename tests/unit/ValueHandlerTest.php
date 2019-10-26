<?php
/**
 * LanguageSpecific
 * Copyright © 2019 Volkhin Nikolay
 * 26.10.2019, 13:15
 */

use LanguageSpecific\ValueHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class ValueHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT
 *           https://github.com/SbWereWolf/language-specific/blob/develop/LICENSE
 * @link     https://github.com/SbWereWolf/language-specific
 */
class ValueHandlerTest extends TestCase
{
    /**
     * Проверяем метод ValueHandler::asIs()
     *
     * @return void
     */
    public function testAsIs()
    {
        $value = new ValueHandler(null);
        self::assertTrue(
            is_null($value->asIs()),
            'Value of asIs() MUST BE null'
        );

        $value = new ValueHandler(1);
        self::assertTrue(
            $value->asIs() === 1,
            'Value of asIs() MUST BE exact 1'
        );

        $value = new ValueHandler('1');
        self::assertTrue(
            $value->asIs() === '1',
            'Value of asIs() MUST BE exact `1`'
        );

        $value = new ValueHandler(true);
        self::assertTrue(
            $value->asIs() === true,
            'Value of asIs() MUST BE exact TRUE'
        );

        $value = new ValueHandler(false);
        self::assertTrue(
            $value->asIs() === false,
            'Value of asIs() MUST BE exact FALSE'
        );

        $value = new ValueHandler(1.1);
        self::assertTrue(
            $value->asIs() === 1.1,
            'Value of asIs() MUST BE exact 1.1'
        );
    }

    /**
     * Проверяем метод ValueHandler::int()
     *
     * @return void
     */
    public function testInt()
    {
        $value = new ValueHandler(null);
        self::assertTrue(
            $value->int() === 0,
            'int() for NULL value MUST BE zero'
        );
        self::assertTrue(
            $value->_isNull() === true,
            'isNull() for NULL value MUST BE true'
        );

        $value = new ValueHandler(1);
        self::assertTrue(
            $value->int() === 1,
            'int() MUST BE exact 1'
        );
        self::assertTrue(
            $value->_isNull() === false,
            'isNull() for not NULL value MUST BE false'
        );
    }

    /**
     * Проверяем метод ValueHandler::bool()
     *
     * @return void
     */
    public function testBool()
    {
        $value = new ValueHandler(null);
        self::assertTrue(
            $value->bool() === false,
            ' bool() for NULL value MUST BE false'
        );
        self::assertTrue(
            $value->_isNull() === true,
            'isNull() for NULL value MUST BE true'
        );

        $value = new ValueHandler(true);
        self::assertTrue(
            $value->bool() === true,
            'bool() MUST BE exact true'
        );
        self::assertTrue(
            $value->_isNull() === false,
            'isNull() for not NULL value MUST BE false'
        );

        $value = new ValueHandler(false);
        self::assertTrue(
            $value->bool() === false,
            'bool() MUST BE exact false'
        );
        self::assertTrue(
            $value->_isNull() === false,
            'isNull() for not NULL value MUST BE false'
        );
    }

    /**
     * Проверяем метод ValueHandler::str()
     *
     * @return void
     */
    public function testStr()
    {
        $value = new ValueHandler(null);
        self::assertTrue(
            $value->str() === '',
            'str() for NULL value MUST BE `` (empty string)'
        );
        self::assertTrue(
            $value->_isNull() === true,
            'isNull() for NULL value MUST BE true'
        );

        $value = new ValueHandler('a');
        self::assertTrue(
            $value->str() === 'a',
            ' str() MUST BE exact `a`'
        );
        self::assertTrue(
            $value->_isNull() === false,
            'isNull() for not NULL value MUST BE false'
        );
    }

    /**
     * Проверяем метод ValueHandler::double()
     *
     * @return void
     */
    public function testDouble()
    {
        $value = new ValueHandler(null);
        self::assertTrue(
            $value->double() === 0.0,
            'double() for NULL value MUST BE 0.0'
        );
        self::assertTrue(
            $value->_isNull() === true,
            'isNull() for NULL value MUST BE true'
        );

        $value = new ValueHandler(1.1);
        self::assertTrue(
            $value->double() === 1.1,
            'Value of double() MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->_isNull() === false,
            'double() for not NULL value MUST BE false'
        );
    }

    /**
     * Проверяем метод ValueHandler::array()
     *
     * @return void
     */
    public function testArray()
    {
        $value = new ValueHandler(null);
        self::assertTrue(
            empty(array_diff($value->array(), [])),
            'For NULL value array() MUST BE []'
        );
        self::assertTrue(
            $value->_isNull() === true,
            'For NULL value isNull() MUST BE true'
        );

        $value = new ValueHandler(array(false, 1, 'a'));
        self::assertTrue(
            empty(array_diff($value->array(), [false, 1, 'a'])),
            'MUST BE exact [false,1,`a`]'
        );
        self::assertTrue(
            $value->_isNull() === false,
            'For not NULL value MUST BE false'
        );
    }

    /**
     * Проверяем метод ValueHandler::type()
     *
     * @return void
     */
    public function testType()
    {
        $type = (new ValueHandler(null))->type();
        self::assertEquals(
            'NULL',
            $type,
            'For NULL value type() MUST BE `NULL`'
        );

        $type = (new ValueHandler(false))->type();
        self::assertEquals(
            'boolean',
            $type,
            'For false value type() MUST BE `boolean`'
        );

        $type = (new ValueHandler(0))->type();
        self::assertEquals(
            'integer',
            $type,
            'For 0 value type() MUST BE `integer`'
        );

        $type = (new ValueHandler(0.0))->type();
        self::assertEquals(
            'double',
            $type,
            'For 0.0 value type() MUST BE `double`'
        );

        $type = (new ValueHandler('a'))->type();
        self::assertEquals(
            'string',
            $type,
            'For `a` value type() MUST BE `string`'
        );

        $type = (new ValueHandler([]))->type();
        self::assertEquals(
            'array',
            $type,
            'For [] value type() MUST BE `array`'
        );

        $type = (new ValueHandler(new ValueHandler()))->type();
        self::assertEquals(
            'object',
            $type,
            'For (new ValueHandler()) value type() MUST BE `object`'
        );
    }

    /**
     * Проверяем метод ValueHandler::object()
     *
     * @return void
     */
    public function testObject()
    {
        $value = (new ValueHandler(new ValueHandler()))->object();

        self::assertTrue(
            is_object($value),
            'For (new ValueHandler()) value'
            . ' object() MUST BE type of object'
        );

        self::assertTrue(
            $value instanceof ValueHandler,
            'For (new ValueHandler()) value'
            . ' object() MUST BE instance of ValueHandler'
        );
    }
}
