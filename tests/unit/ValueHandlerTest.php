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
use SbWereWolf\LanguageSpecific\ValueHandler;
use SbWereWolf\LanguageSpecific\ValueHandlerFactory;
use SbWereWolf\LanguageSpecific\ValueHandlerInterface;

/**
 * Class ValueHandlerTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @license  MIT https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/LICENSE
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
        $value = ValueHandlerFactory::makeValueHandler();
        self::assertTrue(
            is_null($value->asIs()),
            'Value of asIs() MUST BE null'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(1);
        self::assertTrue(
            $value->asIs() === 1,
            'Value of asIs() MUST BE exact 1'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler('1');
        self::assertTrue(
            $value->asIs() === '1',
            'Value of asIs() MUST BE exact `1`'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(true);
        self::assertTrue(
            $value->asIs() === true,
            'Value of asIs() MUST BE exact TRUE'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(false);
        self::assertTrue(
            $value->asIs() === false,
            'Value of asIs() MUST BE exact FALSE'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(1.1);
        self::assertTrue(
            $value->asIs() === 1.1,
            'Value of asIs() MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler([]);
        self::assertTrue(
            empty(array_diff($value->asIs(), [])),
            'For for empty array value of asIs() MUST BE []'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler([false, 1, 'a']);
        self::assertTrue(
            empty(array_diff($value->asIs(), [false, 1, 'a'])),
            'MUST BE exact [false,1,`a`]'
        );
        self::assertTrue(
            $value->wasDefined(),
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
        $value = ValueHandlerFactory::makeValueHandler();
        self::assertTrue(
            $value->int() === 0,
            'int() for NULL value MUST BE zero'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(1);
        self::assertTrue(
            $value->int() === 1,
            'int() MUST BE exact 1'
        );
        self::assertTrue(
            $value->wasDefined(),
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
        $value = ValueHandlerFactory::makeValueHandler();
        self::assertTrue(
            $value->bool() === false,
            ' bool() for NULL value MUST BE false'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(true);
        self::assertTrue(
            $value->bool() === true,
            'bool() MUST BE exact true'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(false);
        self::assertTrue(
            $value->bool() === false,
            'bool() MUST BE exact false'
        );
        self::assertTrue(
            $value->wasDefined(),
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
        $value = ValueHandlerFactory::makeValueHandler();
        self::assertTrue(
            $value->str() === '',
            'str() for NULL value MUST BE `` (empty string)'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler('a');
        self::assertTrue(
            $value->str() === 'a',
            ' str() MUST BE exact `a`'
        );
        self::assertTrue(
            $value->wasDefined(),
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
        $value = ValueHandlerFactory::makeValueHandler();
        self::assertTrue(
            $value->double() === 0.0,
            'double() for NULL value MUST BE 0.0'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler(1.1);
        self::assertTrue(
            $value->double() === 1.1,
            'Value of double() MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->wasDefined(),
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
        $value = ValueHandlerFactory::makeValueHandler();
        self::assertTrue(
            empty(array_diff($value->array(), [])),
            'For NULL value array() MUST BE []'
        );
        self::assertTrue(
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );

        $value = ValueHandlerFactory::makeValueHandler([false, 1, 'a']);
        self::assertTrue(
            empty(array_diff($value->array(), [false, 1, 'a'])),
            'MUST BE exact [false,1,`a`]'
        );
        self::assertTrue(
            $value->wasDefined(),
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
        $value = ValueHandlerFactory::makeValueHandler();
        $type = $value->type();
        self::assertEquals(
            'NULL',
            $type,
            'For NULL value type() MUST BE `NULL`'
        );

        $value = ValueHandlerFactory::makeValueHandler(false);
        $type = $value->type();
        self::assertEquals(
            'boolean',
            $type,
            'For false value type() MUST BE `boolean`'
        );

        $value = ValueHandlerFactory::makeValueHandler(1);
        $type = $value->type();
        self::assertEquals(
            'integer',
            $type,
            'For 0 value type() MUST BE `integer`'
        );

        $value = ValueHandlerFactory::makeValueHandler(0.1);
        $type = $value->type();
        self::assertEquals(
            'double',
            $type,
            'For 0.0 value type() MUST BE `double`'
        );

        $value = ValueHandlerFactory::makeValueHandler('a');
        $type = $value->type();
        self::assertEquals(
            'string',
            $type,
            'For `a` value type() MUST BE `string`'
        );

        $value = ValueHandlerFactory::makeValueHandler([]);
        $type = $value->type();
        self::assertEquals(
            'array',
            $type,
            'For [] value type() MUST BE `array`'
        );

        $value = ValueHandlerFactory::makeValueHandler(
            ValueHandlerFactory::makeValueHandler()
        );
        $type = $value->type();
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
        $value = ValueHandlerFactory::makeValueHandler(
            ValueHandlerFactory::makeValueHandler(1)
        );
        /* @var $value ValueHandler */
        $value = $value->object();

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
            $value->wasDefined(),
            'Flag `has` MUST BE true'
        );
        self::assertTrue(
            $value->asIs() === 1,
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
        $fabric = new ValueHandlerFactory();
        $value = $fabric::makeValueHandlerWithoutValue();

        self::assertFalse(
            $value->wasDefined(),
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

    /**
     * Проверяем использование значения по умолчанию
     *
     * @return void
     */
    public function testWith()
    {
        $this->checkWithInt();
        $this->checkWithDouble();
        $this->checkWithBool();
        $this->checkWithStr();
        $this->checkWithArray();
        $this->checkWithObject();
    }

    /**
     * @return ValueHandlerInterface
     */
    private function checkWithInt()
    {
        $value = ValueHandlerFactory::makeValueHandlerWithoutValue()
            ->default(1);
        self::assertTrue(
            $value->int() === 1,
            'For undefined with(1) value of int() MUST BE exact 1'
        );
        self::assertFalse(
            $value->wasDefined(),
            'For undefined with(1) has() MUST BE false'
        );

        $value = ValueHandlerFactory::makeValueHandler(3);
        $value = $value->default(1);
        self::assertTrue(
            $value->int() === 3,
            'For Value(3) with(1) value of int() MUST BE exact 3'
        );
        self::assertTrue(
            $value->wasDefined(),
            'For Value(3) with(1) has() MUST BE true'
        );

        return $value;
    }

    /**
     * @return ValueHandlerInterface
     */
    private function checkWithDouble()
    {
        $value = ValueHandlerFactory::makeValueHandlerWithoutValue()
            ->default(0.9);
        self::assertTrue(
            $value->double() === 0.9,
            'For undefined with(0.9) value of double()'
            . ' MUST BE exact 0.9'
        );
        self::assertFalse(
            $value->wasDefined(),
            'For undefined with(0.9) has() MUST BE false'
        );
        $value = ValueHandlerFactory::makeValueHandler(1.1)
            ->default(0.9);
        self::assertTrue(
            $value->double() === 1.1,
            'For Value(1.1) with(0.9) value of double()'
            . ' MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->wasDefined(),
            'For Value(1.1) with(0.9) has() MUST BE true'
        );

        return $value;
    }

    /**
     * @return ValueHandlerInterface
     */
    private function checkWithBool()
    {
        $value = ValueHandlerFactory::makeValueHandlerWithoutValue()
            ->default(true);
        self::assertTrue(
            $value->bool() === true,
            'For undefined with(true) value of bool()'
            . ' MUST BE exact true'
        );
        self::assertFalse(
            $value->wasDefined(),
            'For undefined with(true) has() MUST BE false'
        );
        $value = ValueHandlerFactory::makeValueHandler(false)
            ->default(true);
        self::assertTrue(
            $value->bool() === false,
            'For Value(false) with(true) value of bool()'
            . ' MUST BE exact false'
        );
        self::assertTrue(
            $value->wasDefined(),
            'For Value(false) with(true) has() MUST BE true'
        );

        return $value;
    }

    /**
     * @return ValueHandlerInterface
     */
    private function checkWithStr()
    {
        $value = ValueHandlerFactory::makeValueHandlerWithoutValue()
            ->default('a');
        self::assertTrue(
            $value->str() === 'a',
            'For undefined with(`a`) value of str()'
            . ' MUST BE exact `a`'
        );
        self::assertFalse(
            $value->wasDefined(),
            'For undefined with(`a`) has() MUST BE false'
        );
        $value = ValueHandlerFactory::makeValueHandler('b')
            ->default('a');
        self::assertTrue(
            $value->str() === 'b',
            'For Value(`b`) with(`a`) value of str()'
            . ' MUST BE exact `b`'
        );
        self::assertTrue(
            $value->wasDefined(),
            'For Value(`b`) with(`a`) has() MUST BE true'
        );

        return $value;
    }

    /**
     * @return ValueHandlerInterface
     */
    private function checkWithArray()
    {
        $value = ValueHandlerFactory::makeValueHandlerWithoutValue()
            ->default([0 => 1]);
        self::assertTrue(
            $value->array()[0] === 1,
            'For undefined with([0 => 1]) value of asArray()[0]'
            . ' MUST BE exact 1'
        );
        self::assertFalse(
            $value->wasDefined(),
            'For undefined with([0 => 1]) has() MUST BE false'
        );
        $value = ValueHandlerFactory::makeValueHandler([2 => 3])
            ->default([0 => 1]);
        self::assertTrue(
            $value->array()[2] === 3,
            'For Value([2 => 3]) with([0 => 1])'
            . 'value of asArray()[2] MUST BE exact 3'
        );
        self::assertTrue(
            $value->wasDefined(),
            'For Value([2 => 3]) with([0 => 1]) has() MUST BE true'
        );

        return $value;
    }

    /**
     * @return ValueHandlerInterface
     */
    private function checkWithObject()
    {
        $value = ValueHandlerFactory::makeValueHandlerWithoutValue()
            ->default(ValueHandlerFactory::makeValueHandler(1));
        self::assertTrue(
            $value->object()->int() === 1,
            'For undefined with() (new ValueHandler(1))'
            . ' value of object()->int() MUST BE exact 1'
        );
        self::assertFalse(
            $value->wasDefined(),
            'For undefined with() (new ValueHandler(1))'
            . ' has() MUST BE false'
        );
        $internal = ValueHandlerFactory::makeValueHandler(2);
        $external = ValueHandlerFactory::makeValueHandler($internal);
        $default = ValueHandlerFactory::makeValueHandler(1);

        $external->default($default);
        self::assertTrue(
            $external->object()->int() === 2,
            'For Value(ValueHandler(2)) with(ValueHandler(1))'
            . 'value of object()->int() MUST BE exact 2'
        );
        self::assertTrue(
            $external->wasDefined(),
            'For Value(ValueHandler(2)) with(ValueHandler(1))'
            . ' has() MUST BE true'
        );

        return $external;
    }
}
