<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2026 Volkhin Nikolay
 * 3/20/26, 2:53 AM
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;
use SbWereWolf\LanguageSpecific\Value\CommonValue;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

final class DocumentationNamedExampleClass
{
}

final class DocumentationExamplesTest extends TestCase
{
    public function testKillerFeatureSafeNestedConfigAccess(): void
    {
        $factory = new AdvancedArrayFactory();
        $config = $factory->makeAdvancedArray([
            'app' => [
                'cache' => [
                    'driver' => 'redis',
                ],
            ],
        ]);

        $driver = $config
            ->pull('app')
            ->pull('cache')
            ->get('driver')
            ->default('file')
            ->str();

        $fallback = $config
            ->pull('app')
            ->pull('queue')
            ->get('driver')
            ->default('sync')
            ->str();

        self::assertSame('redis', $driver);
        self::assertSame('sync', $fallback);
    }

    public function testKillerFeatureHttpPayloadParsing(): void
    {
        $factory = new AdvancedArrayFactory();
        $payload = $factory->makeAdvancedArray([
            'user' => [
                'id' => '42',
                'is_admin' => '1',
            ],
        ]);

        $userId = $payload->pull('user')->get('id')->int();
        $isAdmin = $payload->pull('user')->get('is_admin')->bool();
        $timezone = $payload->pull('user')->get('timezone')->default('UTC')->str();

        self::assertSame(42, $userId);
        self::assertTrue($isAdmin);
        self::assertSame('UTC', $timezone);
    }

    public function testKillerFeatureLegacyArraysNormalization(): void
    {
        $factory = new ArrayFactory();
        $legacy = $factory->makeCommonArray('legacy-value');

        self::assertTrue($legacy->hasAny());
        self::assertSame('legacy-value', $legacy->getAny()->str());
        self::assertSame('legacy-value', $legacy->get(0)->str());
    }

    public function testAdvancedArrayFactoryCreationExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            'service' => [
                'name' => 'Billing',
            ],
        ]);

        self::assertFalse($data->isDummy());
        self::assertSame('Billing', $data->pull('service')->get('name')->str());
    }

    public function testAdvancedArrayPullExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            [
                'config' => [
                    'env' => [
                        'name' => 'production',
                    ],
                ],
            ],
            'meta' => [
                'region' => 'eu',
            ],
        ]);

        self::assertSame(
            'production',
            $data->pull()->pull('config')->pull('env')->get('name')->str()
        );
        self::assertSame('eu', $data->pull('meta')->get('region')->str());
    }

    public function testAdvancedArrayIsDummyExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            'first' => [
                'A' => 1,
            ],
        ]);

        self::assertFalse($data->pull('first')->isDummy());
        self::assertTrue($data->pull('missing')->isDummy());
    }

    public function testAdvancedArrayGetExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            'name' => 'Mike',
            'salary' => 19999.99,
        ]);

        self::assertSame('Mike', $data->get('name')->str());
        self::assertSame(19999, $data->get('salary')->int());
        self::assertNull($data->get('missing')->asIs());
        self::assertFalse($data->get('missing')->isReal());
    }

    public function testAdvancedArrayGetAnyExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $filled = $factory->makeAdvancedArray([
            'first' => 'A',
            'second' => 'B',
        ]);
        $empty = $factory->makeAdvancedArray([]);

        self::assertSame('A', $filled->getAny()->str());
        self::assertTrue($filled->getAny()->isReal());
        self::assertNull($empty->getAny()->asIs());
        self::assertFalse($empty->getAny()->isReal());
    }

    public function testAdvancedArrayHasExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            0 => 'first',
            'next' => 2,
        ]);

        self::assertTrue($data->has(0));
        self::assertTrue($data->has('next'));
        self::assertFalse($data->has('missing'));
    }

    public function testAdvancedArrayHasAnyExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $filled = $factory->makeAdvancedArray([
            'first' => 1,
        ]);
        $empty = $factory->makeAdvancedArray([]);

        self::assertTrue($filled->hasAny());
        self::assertFalse($empty->hasAny());
    }

    public function testAdvancedArrayArraysExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            [
                'name' => 'first',
            ],
            [
                'name' => 'second',
            ],
            'tail',
        ]);

        $names = [];
        foreach ($data->arrays() as $nested) {
            $names[] = $nested->get('name')->str();
        }

        self::assertSame(['first', 'second'], $names);
    }

    public function testAdvancedArrayValuesExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            [
                'skip' => true,
            ],
            'first',
            'next',
            'last',
        ]);

        $values = [];
        foreach ($data->values() as $value) {
            $values[] = $value->str();
        }

        self::assertSame(['first', 'next', 'last'], $values);
    }

    public function testCommonValueAsIsExample(): void
    {
        $value = CommonValueFactory::makeCommonValue([
            'env' => 'prod',
        ]);

        self::assertSame(['env' => 'prod'], $value->asIs());
    }

    public function testCommonValueIsRealAndDefaultExample(): void
    {
        $dummy = CommonValueFactory::makeCommonValueAsDummy();
        $real = CommonValueFactory::makeCommonValue('real value');

        self::assertFalse($dummy->isReal());
        self::assertNull($dummy->asIs());
        self::assertSame('fallback', $dummy->default('fallback')->str());

        self::assertTrue($real->isReal());
        self::assertSame('real value', $real->default('fallback')->str());
    }

    public function testCommonValueScalarCastExample(): void
    {
        $value = CommonValueFactory::makeCommonValue('1.1');

        self::assertSame('1.1', $value->str());
        self::assertSame(1, $value->int());
        self::assertSame(1.1, $value->double());
        self::assertTrue($value->bool());
    }

    public function testCommonValueArrayExample(): void
    {
        $stringValue = CommonValueFactory::makeCommonValue('release');
        $arrayValue = CommonValueFactory::makeCommonValue([
            'env' => 'prod',
        ]);

        self::assertSame(['release'], $stringValue->array());
        self::assertSame(['env' => 'prod'], $arrayValue->array());
    }

    public function testCommonValueObjectExample(): void
    {
        $inner = CommonValueFactory::makeCommonValue(1);
        $outer = CommonValueFactory::makeCommonValue($inner);
        $object = $outer->object();

        self::assertInstanceOf(CommonValue::class, $object);
        self::assertSame(1, $object->asIs());
    }

    public function testCommonValueTypeExample(): void
    {
        $stream = fopen('php://memory', 'r');

        $results = [
            CommonValueFactory::makeCommonValue(null)->type(),
            CommonValueFactory::makeCommonValue(false)->type(),
            CommonValueFactory::makeCommonValue(0)->type(),
            CommonValueFactory::makeCommonValue(0.1)->type(),
            CommonValueFactory::makeCommonValue('a')->type(),
            CommonValueFactory::makeCommonValue([])->type(),
            CommonValueFactory::makeCommonValue((object)null)->type(),
            CommonValueFactory::makeCommonValue($stream)->type(),
        ];

        fclose($stream);

        $results[] = CommonValueFactory::makeCommonValue($stream)->type();

        self::assertSame(
            [
                'NULL',
                'boolean',
                'integer',
                'double',
                'string',
                'array',
                'object',
                'resource',
                'resource (closed)',
            ],
            $results
        );
    }

    public function testCommonValueClassExample(): void
    {
        $stream = fopen('php://memory', 'r');
        $anonymous = new class () {
        };

        $results = [
            CommonValueFactory::makeCommonValue(null)->class(),
            CommonValueFactory::makeCommonValue(false)->class(),
            CommonValueFactory::makeCommonValue(0)->class(),
            CommonValueFactory::makeCommonValue(0.1)->class(),
            CommonValueFactory::makeCommonValue('a')->class(),
            CommonValueFactory::makeCommonValue([])->class(),
            CommonValueFactory::makeCommonValue((object)null)->class(),
            CommonValueFactory::makeCommonValue(new DocumentationNamedExampleClass())->class(),
            CommonValueFactory::makeCommonValue($anonymous)->class(),
            CommonValueFactory::makeCommonValue($stream)->class(),
        ];

        fclose($stream);

        $results[] = CommonValueFactory::makeCommonValue($stream)->class();

        self::assertSame(
            [
                'null',
                'bool',
                'int',
                'float',
                'string',
                'array',
                'stdClass',
                DocumentationNamedExampleClass::class,
                'class@anonymous',
                'resource (stream)',
                'resource (closed)',
            ],
            $results
        );
    }

    public function testArrayFactoryMakeBaseArrayExample(): void
    {
        $factory = new ArrayFactory();
        $data = $factory->makeBaseArray('legacy-value');

        self::assertSame(['legacy-value'], $data->raw());
    }

    public function testArrayFactoryMakeCommonArrayExample(): void
    {
        $factory = new ArrayFactory();
        $data = $factory->makeCommonArray([
            'id' => '42',
            'enabled' => '1',
        ]);

        self::assertSame(42, $data->get('id')->int());
        self::assertTrue($data->get('enabled')->bool());
    }

    public function testCommonArrayGetExample(): void
    {
        $factory = new ArrayFactory();
        $data = $factory->makeCommonArray([
            'name' => 'Alice',
            'age' => '31',
        ]);

        self::assertSame('Alice', $data->get('name')->str());
        self::assertSame(31, $data->get('age')->int());
        self::assertFalse($data->get('missing')->isReal());
    }

    public function testCommonArrayGetAnyExample(): void
    {
        $factory = new ArrayFactory();
        $filled = $factory->makeCommonArray([
            'first' => 'A',
            'second' => 'B',
        ]);
        $empty = $factory->makeCommonArray([]);

        self::assertSame('A', $filled->getAny()->str());
        self::assertFalse($empty->getAny()->isReal());
    }

    public function testCommonArrayHasExample(): void
    {
        $factory = new ArrayFactory();
        $data = $factory->makeCommonArray([
            0 => 'first',
            'next' => 2,
        ]);

        self::assertTrue($data->has(0));
        self::assertTrue($data->has('next'));
        self::assertFalse($data->has('missing'));
    }

    public function testCommonArrayHasAnyExample(): void
    {
        $factory = new ArrayFactory();
        $filled = $factory->makeCommonArray([
            'first' => 1,
        ]);
        $empty = $factory->makeCommonArray([]);

        self::assertTrue($filled->hasAny());
        self::assertFalse($empty->hasAny());
    }

    public function testBaseArrayRawExample(): void
    {
        $factory = new ArrayFactory();
        $data = $factory->makeBaseArray([
            0 => 'first',
            'index' => 20,
            3 => 'last',
        ]);

        self::assertSame(
            [
                0 => 'first',
                'index' => 20,
                3 => 'last',
            ],
            $data->raw()
        );
    }

    public function testFactoryHelpersMakeDummyAdvancedArrayExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $dummy = $factory->makeDummyAdvancedArray();

        self::assertTrue($dummy->isDummy());
        self::assertFalse($dummy->hasAny());
    }

    public function testFactoryHelpersMakeCommonValueExample(): void
    {
        $value = CommonValueFactory::makeCommonValue([
            'region' => 'eu',
        ]);

        self::assertSame('eu', $value->array()['region']);
    }

    public function testFactoryHelpersMakeCommonValueAsDummyExample(): void
    {
        $dummy = CommonValueFactory::makeCommonValueAsDummy();

        self::assertFalse($dummy->isReal());
        self::assertSame('fallback', $dummy->default('fallback')->str());
    }

    public function testNativePhpInterfacesArrayAccessExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            'name' => 'Billing',
            'active' => true,
        ]);

        self::assertSame('Billing', $data['name']->str());
        self::assertTrue($data['active']->bool());
    }

    public function testNativePhpInterfacesForeachExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            'name' => 'Billing',
            'active' => true,
        ]);

        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = $value->asIs();
        }

        self::assertSame(
            [
                'name' => 'Billing',
                'active' => true,
            ],
            $result
        );
    }

    public function testNativePhpInterfacesJsonEncodeExample(): void
    {
        $factory = new AdvancedArrayFactory();
        $data = $factory->makeAdvancedArray([
            'name' => 'Billing',
            'flags' => [
                'active' => true,
            ],
        ]);

        self::assertSame(
            <<<'JSON'
{
    "name": "Billing",
    "flags": {
        "active": true
    }
}
JSON,
            json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)
        );
    }
}
