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
use SbWereWolf\LanguageSpecific\Value\CommonValue;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;
use SbWereWolf\LanguageSpecific\Value\CommonValueInterface;

/**
 * Class CommonValueTest
 *
 * @category Test
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 */
class CommonValueTest extends TestCase
{
    /**
     * Проверяем метод CommonValue::asIs()
     *
     * @return void
     */
    public function testAsIs()
    {
        $value = CommonValueFactory::makeCommonValue();
        self::assertTrue(
            is_null($value->asIs()),
            'Value of asIs() MUST BE null'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(1);
        self::assertTrue(
            $value->asIs() === 1,
            'Value of asIs() MUST BE exact 1'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue('1');
        self::assertTrue(
            $value->asIs() === '1',
            'Value of asIs() MUST BE exact `1`'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(true);
        self::assertTrue(
            $value->asIs() === true,
            'Value of asIs() MUST BE exact TRUE'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(false);
        self::assertTrue(
            $value->asIs() === false,
            'Value of asIs() MUST BE exact FALSE'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(1.1);
        self::assertTrue(
            $value->asIs() === 1.1,
            'Value of asIs() MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue([]);
        self::assertEmpty(
            array_diff($value->asIs(), []),
            'For for empty array value of asIs() MUST BE []'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue([false, 1, 'a']);
        self::assertEmpty(
            array_diff($value->asIs(), [false, 1, 'a']),
            'MUST BE exact [false,1,`a`]'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );
    }

    /**
     * Проверяем метод CommonValue::int()
     *
     * @return void
     */
    public function testInt()
    {
        $value = CommonValueFactory::makeCommonValue();
        self::assertTrue(
            $value->int() === 0,
            'int() for NULL value MUST BE zero'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(1);
        self::assertTrue(
            $value->int() === 1,
            'int() MUST BE exact 1'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );
    }

    /**
     * Проверяем метод CommonValue::bool()
     *
     * @return void
     */
    public function testBool()
    {
        $value = CommonValueFactory::makeCommonValue();
        self::assertTrue(
            $value->bool() === false,
            ' bool() for NULL value MUST BE false'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(true);
        self::assertTrue(
            $value->bool() === true,
            'bool() MUST BE exact true'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(false);
        self::assertTrue(
            $value->bool() === false,
            'bool() MUST BE exact false'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );
    }

    /**
     * Проверяем метод CommonValue::str()
     *
     * @return void
     */
    public function testStr()
    {
        $value = CommonValueFactory::makeCommonValue();
        self::assertTrue(
            $value->str() === '',
            'str() for NULL value MUST BE `` (empty string)'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue('a');
        self::assertTrue(
            $value->str() === 'a',
            ' str() MUST BE exact `a`'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );
    }

    /**
     * Проверяем метод CommonValue::double()
     *
     * @return void
     */
    public function testDouble()
    {
        $value = CommonValueFactory::makeCommonValue();
        self::assertTrue(
            $value->double() === 0.0,
            'double() for NULL value MUST BE 0.0'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue(1.1);
        self::assertTrue(
            $value->double() === 1.1,
            'Value of double() MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );
    }

    /**
     * Проверяем метод CommonValue::array()
     *
     * @return void
     */
    public function testArray()
    {
        $value = CommonValueFactory::makeCommonValue();
        self::assertEmpty(
            array_diff($value->array(), []),
            'For NULL value array() MUST BE []'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );

        $value = CommonValueFactory::makeCommonValue([false, 1, 'a']);
        self::assertEmpty(
            array_diff($value->array(), [false, 1, 'a']),
            'MUST BE exact [false,1,`a`]'
        );
        self::assertTrue(
            $value->isReal(),
            'Flag `is real` MUST BE true'
        );
    }

    /**
     * Проверяем метод CommonValue::type()
     *
     * @return void
     */
    public function testType()
    {
        $value = CommonValueFactory::makeCommonValue();
        $type = $value->type();
        self::assertEquals(
            'NULL',
            $type,
            'For NULL value type() MUST BE `NULL`'
        );

        $value = CommonValueFactory::makeCommonValue(false);
        $type = $value->type();
        self::assertEquals(
            'boolean',
            $type,
            'For false value type() MUST BE `boolean`'
        );

        $value = CommonValueFactory::makeCommonValue(1);
        $type = $value->type();
        self::assertEquals(
            'integer',
            $type,
            'For 0 value type() MUST BE `integer`'
        );

        $value = CommonValueFactory::makeCommonValue(0.1);
        $type = $value->type();
        self::assertEquals(
            'double',
            $type,
            'For 0.1 value type() MUST BE `double`'
        );

        $value = CommonValueFactory::makeCommonValue('a');
        $type = $value->type();
        self::assertEquals(
            'string',
            $type,
            'For `a` value type() MUST BE `string`'
        );

        $value = CommonValueFactory::makeCommonValue([]);
        $type = $value->type();
        self::assertEquals(
            'array',
            $type,
            'For [] value type() MUST BE `array`'
        );

        $value = CommonValueFactory::makeCommonValue(
            CommonValueFactory::makeCommonValue()
        );
        $type = $value->type();
        self::assertEquals(
            'object',
            $type,
            'For (new CommonValue()) value type() MUST BE `object`'
        );
    }

    /**
     * Проверяем метод CommonValue::object()
     *
     * @return void
     */
    public function testObject()
    {
        $value = CommonValueFactory::makeCommonValue(
            CommonValueFactory::makeCommonValue(1)
        );
        /* @var $value \SbWereWolf\LanguageSpecific\Value\CommonValue */
        $sample = $value->object();

        self::assertTrue(
            is_object($sample),
            'For (new CommonValue()) value of object() method'
            . ' MUST BE type of object'
        );
        self::assertTrue(
            $sample instanceof CommonValue,
            'For (new CommonValue()) value of object()'
            . ' MUST BE instance of CommonValue'
        );
        self::assertTrue(
            $sample->isReal(),
            'Flag `is real` MUST BE true'
        );
        self::assertTrue(
            $sample->asIs() === 1,
            'Value of asIs() MUST BE zero'
        );
    }

    /**
     * Проверяем создание незаданного Значения
     *
     * @return void
     */
    public function testIsReal()
    {
        $fabric = new CommonValueFactory();
        $value = $fabric::makeCommonValueAsDummy();

        self::assertFalse(
            $value->isReal(),
            'Flag `is real` For dummy Value MUST BE false'
        );
        self::assertTrue(
            gettype($value->asIs()) === 'NULL',
            'For dummy Value type of returning value of'
            . ' asIs() MUST BE NULL'
        );
        self::assertTrue(
            is_null($value->asIs()),
            'For dummy Value asIs() MUST BE null'
        );
    }

    /**
     * Проверяем использование значения по умолчанию
     *
     * @return void
     */
    public function testDefault()
    {
        $this->checkDefaultInt();
        $this->checkDefaultDouble();
        $this->checkDefaultBool();
        $this->checkDefaultStr();
        $this->checkDefaultArray();
        $this->checkDefaultObject();
    }

    /**
     * @return \SbWereWolf\LanguageSpecific\Value\CommonValueInterface
     */
    private function checkDefaultInt()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy()
            ->default(1);
        self::assertTrue(
            $value->int() === 1,
            'For dummy with default(1) value of int() MUST BE exact 1'
        );
        self::assertFalse(
            $value->isReal(),
            'For dummy with default(1) isReal() MUST BE false'
        );

        $value = CommonValueFactory::makeCommonValue(3);
        $value = $value->default(1);
        self::assertTrue(
            $value->int() === 3,
            'For value(3) with default(1) int() MUST BE exact 3'
        );
        self::assertTrue(
            $value->isReal(),
            'For value(3) with default(1) isReal() MUST BE true'
        );

        return $value;
    }

    /**
     * @return \SbWereWolf\LanguageSpecific\Value\CommonValueInterface
     */
    private function checkDefaultDouble()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy()
            ->default(0.9);
        self::assertTrue(
            $value->double() === 0.9,
            'For dummy with default(0.9) value of double()'
            . ' MUST BE exact 0.9'
        );
        self::assertFalse(
            $value->isReal(),
            'For dummy with default(0.9) isReal() MUST BE false'
        );
        $value = CommonValueFactory::makeCommonValue(1.1)
            ->default(0.9);
        self::assertTrue(
            $value->double() === 1.1,
            'For value(1.1) with default(0.9) value of double()'
            . ' MUST BE exact 1.1'
        );
        self::assertTrue(
            $value->isReal(),
            'For value(1.1) with default(0.9) isReal() MUST BE true'
        );

        return $value;
    }

    /**
     * @return \SbWereWolf\LanguageSpecific\Value\CommonValueInterface
     */
    private function checkDefaultBool()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy()
            ->default(true);
        self::assertTrue(
            $value->bool() === true,
            'For dummy with default(true) value of bool()'
            . ' MUST BE exact true'
        );
        self::assertFalse(
            $value->isReal(),
            'For dummy with default(true) isReal() MUST BE false'
        );
        $value = CommonValueFactory::makeCommonValue(false)
            ->default(true);
        self::assertTrue(
            $value->bool() === false,
            'For value(false) with default(true) value of bool()'
            . ' MUST BE exact false'
        );
        self::assertTrue(
            $value->isReal(),
            'For value(false) with default(true) isReal() MUST BE true'
        );

        return $value;
    }

    /**
     * @return CommonValueInterface
     */
    private function checkDefaultStr()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy()
            ->default('a');
        self::assertTrue(
            $value->str() === 'a',
            'For dummy with default(`a`) value of str()'
            . ' MUST BE exact `a`'
        );
        self::assertFalse(
            $value->isReal(),
            'For dummy with default(`a`) isReal() MUST BE false'
        );
        $value = CommonValueFactory::makeCommonValue('b')
            ->default('a');
        self::assertTrue(
            $value->str() === 'b',
            'For value(`b`) with default(`a`) value of str()'
            . ' MUST BE exact `b`'
        );
        self::assertTrue(
            $value->isReal(),
            'For value(`b`) with default(`a`) isReal() MUST BE true'
        );

        return $value;
    }

    /**
     * @return CommonValueInterface
     */
    private function checkDefaultArray()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy()
            ->default([0 => 1]);
        self::assertTrue(
            $value->array()[0] === 1,
            'For dummy with default([0 => 1]) value of array()[0]'
            . ' MUST BE exact 1'
        );
        self::assertFalse(
            $value->isReal(),
            'For dummy with default([0 => 1]) isReal() MUST BE false'
        );
        $value = CommonValueFactory::makeCommonValue([2 => 3])
            ->default([0 => 1]);
        self::assertTrue(
            $value->array()[2] === 3,
            'For value([2 => 3]) with default([0 => 1])'
            . 'value of array()[2] MUST BE exact 3'
        );
        self::assertTrue(
            $value->isReal(),
            'For value([2 => 3]) with default([0 => 1])'
            . ' isReal() MUST BE true'
        );

        return $value;
    }

    /**
     * @return \SbWereWolf\LanguageSpecific\Value\CommonValueInterface
     */
    private function checkDefaultObject()
    {
        $value = CommonValueFactory::makeCommonValueAsDummy()
            ->default(CommonValueFactory::makeCommonValue(1));
        self::assertTrue(
            $value->object()->int() === 1,
            'For dummy with default(new CommonValue(1))'
            . ' value of object()->int() MUST BE exact 1'
        );
        self::assertFalse(
            $value->isReal(),
            'For dummy with default(new CommonValue(1))'
            . ' isReal() MUST BE false'
        );
        $internal = CommonValueFactory::makeCommonValue(2);
        $external = CommonValueFactory::makeCommonValue($internal);
        $default = CommonValueFactory::makeCommonValue(1);

        $external->default($default);
        self::assertTrue(
            $external->object()->int() === 2,
            'For value(CommonValue(2)) with default(CommonValue(1))'
            . 'value of object()->int() MUST BE exact 2'
        );
        self::assertTrue(
            $external->isReal(),
            'For value(CommonValue(2)) with default(CommonValue(1))'
            . ' isReal() MUST BE true'
        );

        return $external;
    }
}
