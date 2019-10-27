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

use LanguageSpecific\ValueHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class ValueHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/LICENSE
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
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(1);
        self::assertTrue(
            $value->asIs() === 1,
            'Value of asIs() MUST BE exact 1'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler('1');
        self::assertTrue(
            $value->asIs() === '1',
            'Value of asIs() MUST BE exact `1`'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(true);
        self::assertTrue(
            $value->asIs() === true,
            'Value of asIs() MUST BE exact TRUE'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(false);
        self::assertTrue(
            $value->asIs() === false,
            'Value of asIs() MUST BE exact FALSE'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(1.1);
        self::assertTrue(
            $value->asIs() === 1.1,
            'Value of asIs() MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler([]);
        self::assertTrue(
            empty(array_diff($value->asIs(), [])),
            'For for empty array value of asIs() MUST BE []'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler([false, 1, 'a']);
        self::assertTrue(
            empty(array_diff($value->asIs(), [false, 1, 'a'])),
            'MUST BE exact [false,1,`a`]'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
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
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(1);
        self::assertTrue(
            $value->int() === 1,
            'int() MUST BE exact 1'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
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
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(true);
        self::assertTrue(
            $value->bool() === true,
            'bool() MUST BE exact true'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(false);
        self::assertTrue(
            $value->bool() === false,
            'bool() MUST BE exact false'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
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
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler('a');
        self::assertTrue(
            $value->str() === 'a',
            ' str() MUST BE exact `a`'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
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
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(1.1);
        self::assertTrue(
            $value->double() === 1.1,
            'Value of double() MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
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
            empty(array_diff($value->asArray(), [])),
            'For NULL value array() MUST BE []'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );

        $value = new ValueHandler(array(false, 1, 'a'));
        self::assertTrue(
            empty(array_diff($value->asArray(), [false, 1, 'a'])),
            'MUST BE exact [false,1,`a`]'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
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
        /* @var $value ValueHandler */
        $value = (new ValueHandler(new ValueHandler(0)))->object();

        self::assertTrue(
            is_object($value),
            'For (new ValueHandler()) value of object() method'
            . ' MUST BE type of object'
        );
        self::assertTrue(
            $value instanceof ValueHandler,
            'For (new ValueHandler()) value of object() method'
            . ' MUST BE instance of ValueHandler'
        );
        self::assertTrue(
            $value->has(),
            'Flag `has` MUST BE true'
        );
        self::assertTrue(
            $value->asIs() === 0,
            'Value of asIs() MUST BE zero'
        );
    }

    /**
     * Проверяем создание незаданного Значения
     *
     * @return void
     */
    public function testUndefined()
    {
        $value = ValueHandler::asUndefined();

        self::assertFalse(
            $value->has(),
            'Flag `has` for undefined Value MUST BE false'
        );
        self::assertTrue(
            gettype($value->asIs()) === 'NULL',
            'For undefined Value type of returning value of'
            . ' asIs() MUST BE NULL'
        );
        self::assertTrue(
            is_null($value->asIs()),
            'For undefined Value asIs() MUST BE null'
        );
    }
}
