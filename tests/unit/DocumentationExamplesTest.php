<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;
use SbWereWolf\LanguageSpecific\Value\CommonValue;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

final class DocumentationExamplesTest extends TestCase
{
    public function testQuickStartExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $employee = $factory->makeAdvancedArray([
            'name' => 'Mike',
            'salary' => 19999.99,
        ]);

        self::assertSame('Mike', $employee->get('name')->str());
        self::assertSame(19999, $employee->get('salary')->int());
    }

    public function testCommonArrayExample(): void
    {
        $factory = new ArrayFactory();
        $data = $factory->makeCommonArray([
            0 => 'first',
            'index' => 20,
            3 => 'last',
        ]);

        self::assertTrue($data->has());
        self::assertTrue($data->has(0));
        self::assertFalse($data->has('missing'));
        self::assertSame('first', $data->get()->asIs());
        self::assertFalse($data->get('missing')->isReal());
        self::assertSame(20, $data->get('index')->int());
    }

    public function testAdvancedArrayPullAndIteratorsExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            ['first', 'next', 'last'],
            ['A', 'B', 'C'],
            'tail',
        ]);

        $arrays = [];
        foreach ($data->arrays() as $nested) {
            $arrays[] = $nested->raw();
        }

        $values = [];
        foreach ($data->values() as $value) {
            $values[] = $value->asIs();
        }

        self::assertSame(
            [
                ['first', 'next', 'last'],
                ['A', 'B', 'C'],
            ],
            $arrays
        );
        self::assertSame(['tail'], $values);
        self::assertTrue($data->pull('missing')->isDummy());
        self::assertSame('first', $data->pull(0)->get(0)->str());
    }

    public function testDummyDefaultExample(): void
    {
        $dummy = CommonValueFactory::makeCommonValueAsDummy();
        $real = CommonValueFactory::makeCommonValue('real value');

        self::assertFalse($dummy->isReal());
        self::assertNull($dummy->asIs());
        self::assertSame('fallback', $dummy->default('fallback')->str());
        self::assertSame('real value', $real->default('fallback')->str());
    }

    public function testTypeClassAndObjectExamples(): void
    {
        $inner = CommonValueFactory::makeCommonValue(1);
        $outer = CommonValueFactory::makeCommonValue($inner);

        self::assertSame('NULL', CommonValueFactory::makeCommonValue(null)->type());
        self::assertSame('boolean', CommonValueFactory::makeCommonValue(false)->type());
        self::assertSame('double', CommonValueFactory::makeCommonValue(0.1)->type());
        self::assertSame('stdClass', CommonValueFactory::makeCommonValue((object) null)->class());
        self::assertInstanceOf(CommonValue::class, $outer->object());
        self::assertSame(1, $outer->object()->asIs());
    }
}
