# Safe PHP Arrays

[![Packagist Version](https://img.shields.io/packagist/v/sbwerewolf/language-specific)](https://packagist.org/packages/sbwerewolf/language-specific)
[![Packagist Downloads](https://img.shields.io/packagist/dt/sbwerewolf/language-specific)](https://packagist.org/packages/sbwerewolf/language-specific)
[![License](https://img.shields.io/github/license/SbWereWolf/language-specific)](https://github.com/SbWereWolf/language-specific/blob/master/LICENSE)
[![CI](https://github.com/SbWereWolf/language-specific/actions/workflows/ci.yml/badge.svg)](https://github.com/SbWereWolf/language-specific/actions/workflows/ci.yml)
[![Static Analysis](https://github.com/SbWereWolf/language-specific/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/SbWereWolf/language-specific/actions/workflows/static-analysis.yml)
[![Test Coverage](https://codecov.io/github/SbWereWolf/language-specific/graph/badge.svg?token=I71W0AFR98)](https://codecov.io/github/SbWereWolf/language-specific)

Read nested arrays safely and cast values predictably in PHP 7.3

Use it when you need to:

- read nested arrays without long `isset()` (`??`) chains
- normalize request/config payloads with explicit defaults
- keep the “missing value” state visible instead of
  leaking `null` everywhere

## Install

```bash
composer require sbwerewolf/language-specific
```

## Quick example

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$payload = [
    'user' => [
        'id' => '42',
        'role' => 'admin',
    ],
];
$data = new AdvancedArrayFactory()->makeAdvancedArray($payload);

$userId = $data->pull('user')->get('id')->int(); // 42
$timezone = $data->pull('user')->get('timezone')->default('UTC')->str(); // 'UTC'
// -- OR --
$user = $data->pull('user');

$userId = $user->get('id')->int(); // 42
$timezone = $user->get('timezone')->default('UTC')->str(); // 'UTC' 
```

## Code test coverage

![Codecov graph](https://codecov.io/github/SbWereWolf/language-specific/graphs/tree.svg?token=I71W0AFR98)

## Quick navigation

- [Killer features](#killer-features)
- [AdvancedArray](#advancedarray)
- [CommonValue](#commonvalue)
- [ArrayFactory](#arrayfactory)
- [CommonArray](#commonarray)
- [BaseArray](#basearray)
- [Factory helpers](#factory-helpers)
- [Native PHP interfaces](#native-php-interfaces)
- [Run tests](#run-tests)

## Killer features

### 1. Safe nested config access

Use `AdvancedArray` when you need to walk through deeply nested arrays
without `isset()` chains and still keep explicit control over missing values.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

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
    
$driver; // 'redis'

$fallback = $config
    ->pull('app')
    ->pull('queue')
    ->get('driver')
    ->default('sync')
    ->str();

$fallback; // 'sync'
```

Continue with [AdvancedArray](#advancedarray).

### 2. HTTP payload parsing

Use `CommonValue` conversions to normalize request payloads without
sprinkling casts across the whole handler.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$payload = $factory->makeAdvancedArray([
    'user' => [
        'id' => '42',
        'is_admin' => '1',
    ],
]);

$userId = $payload->pull('user')->get('id')->int(); // 42
$isAdmin = $payload->pull('user')->get('is_admin')->bool(); // true

$timezone = $payload->pull('user')->get('timezone')->default('UTC')->str();
// 'UTC'
```

Continue with [AdvancedArray](#advancedarray) and [CommonValue](#commonvalue).

### 3. Legacy arrays normalization

Use factories to turn inconsistent old-style data into one predictable API.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$legacy = $factory->makeCommonArray('legacy-value');

$legacy->hasAny(); // true
$legacy->getAny()->str(); // 'legacy-value'
$legacy->get(0)->str(); // 'legacy-value'
```

Continue with [ArrayFactory](#arrayfactory) and [CommonArray](#commonarray).

## AdvancedArray

Back to [killer features](#killer-features).

### Create an `AdvancedArray` with `makeAdvancedArray()`

Use `AdvancedArrayFactory` as the main entry point for nested data.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    'service' => [
        'name' => 'Billing',
    ],
]);

$data->isDummy(); // false
$data->pull('service')->get('name')->str(); // 'Billing'
```

### `pull()` returns a nested `AdvancedArrayInterface`

`pull()` can return the first nested array or a specific nested array by key.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

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

$data->pull()->pull('config')->pull('env')->get('name')->str(); // 'production'
$data->pull('meta')->get('region')->str(); // 'eu'
```

### `isDummy()` marks a missing nested array

Missing nested arrays return a dummy object instead of throwing or leaking `null`.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    'first' => [
        'A' => 1,
    ],
]);

$data->pull('first')->isDummy(); // false
$data->pull('missing')->isDummy(); // true
```

### `get()` reads a value and keeps the missing-state visible

`get()` returns a `CommonValueInterface`, so you can inspect both the
value and whether the key was actually present.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    'name' => 'Mike',
    'salary' => 19999.99,
]);

$data->get('name')->str(); // 'Mike'
$data->get('salary')->int(); // 19999
$data->get('missing')->asIs(); // null
$data->get('missing')->isReal(); // false
```

### `getAny()` returns the first value or a dummy for an empty collection

Use `getAny()` when any first available value is good enough.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$filled = $factory->makeAdvancedArray([
    'first' => 'A',
    'second' => 'B',
]);

$filled->getAny()->str(); // 'A'
$filled->getAny()->isReal(); // true

$empty = $factory->makeAdvancedArray([]);

$empty->getAny()->asIs(); // null
$empty->getAny()->isReal(); // false
```

### `has()` checks a specific key

Use `has()` when you want to know whether a given key exists before
reading it.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    0 => 'first',
    'next' => 2,
]);

$data->has(0); // true
$data->has('next'); // true
$data->has('missing'); // false
```

### `hasAny()` checks whether the collection is not empty

Use `hasAny()` when you only care whether there is at least one item.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$filled = $factory->makeAdvancedArray([
    'first' => 1,
]);

$filled->hasAny(); // true

$empty = $factory->makeAdvancedArray([]);
$empty->hasAny(); // false
```

### `arrays()` iterates over nested arrays only

This is useful when you need to process nested lists without
checking each item.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

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

$names; // ['first', 'second']
```

### `values()` iterates over non-array elements only

This is useful when the collection mixes nested arrays with
plain scalar values.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

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

$values; // ['first', 'next', 'last']
```

## CommonValue

Back to [killer features](#killer-features).

### `asIs()` returns the stored value exactly as it is

Use `asIs()` when you want the original stored value without casting.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$value = CommonValueFactory::makeCommonValue([
    'env' => 'prod',
]);

$value->asIs(); // ['env' => 'prod']
```

### `isReal()` and `default()` make missing-state explicit

Use `default()` only for missing values; real values stay untouched.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$dummy = CommonValueFactory::makeCommonValueAsDummy();

$dummy->isReal(); // false
$dummy->asIs(); // null
$dummy->default('fallback')->str(); // 'fallback'

$real = CommonValueFactory::makeCommonValue('real value');

$real->isReal(); // true
$real->default('fallback')->str(); // 'real value'
```

### Scalar casts stay close to native PHP casting rules

Use the typed helpers when you want the cast at the point of reading.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$value = CommonValueFactory::makeCommonValue('1.1');

$value->str(); // '1.1'
$value->int(); // 1
$value->double(); // 1.1
$value->bool(); // true
```

### `array()` turns the current value into an array

This is especially useful when you want one array-shaped read path.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$stringValue = CommonValueFactory::makeCommonValue('release');
$stringValue->array(); // ['release']

$arrayValue = CommonValueFactory::makeCommonValue([
    'env' => 'prod',
]);
$arrayValue->array(); // ['env' => 'prod']
```

### `object()` returns the stored object value

When the stored value is already an object,
`object()` returns it unchanged.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValue;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$inner = CommonValueFactory::makeCommonValue(1);
$outer = CommonValueFactory::makeCommonValue($inner);
$object = $outer->object();

$object instanceof CommonValue; // true
$object->asIs(); // 1
```

### `type()` shows all native `gettype()` results used by this library

This example is meant to be read without running it, so every
visible result is listed explicitly.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$stream = fopen('php://memory', 'r');

$results = [
    CommonValueFactory::makeCommonValue(null)->type(), //'NULL'
    CommonValueFactory::makeCommonValue(false)->type(), //'boolean'
    CommonValueFactory::makeCommonValue(0)->type(), //'integer'
    CommonValueFactory::makeCommonValue(0.1)->type(), //'double'
    CommonValueFactory::makeCommonValue('a')->type(), //'string'
    CommonValueFactory::makeCommonValue([])->type(), //'array'
    CommonValueFactory::makeCommonValue((object) null)->type(), //'object'
    CommonValueFactory::makeCommonValue($stream)->type(), //'resource'
];

fclose($stream);

$results[] = CommonValueFactory::makeCommonValue($stream)->type(); 
// 'resource (closed)'

$results;
/*
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
]
*/
```

### `class()` shows all native `get_debug_type()` results used by this library

This example includes scalars, arrays, named classes,
anonymous classes, resources, and closed resources.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

final class DocumentationNamedExampleClass
{
}

$stream = fopen('php://memory', 'r');
$anonymous = new class () {
};

$results = [
    CommonValueFactory::makeCommonValue(null)->class(), // null
    CommonValueFactory::makeCommonValue(false)->class(), // bool
    CommonValueFactory::makeCommonValue(0)->class(), // int
    CommonValueFactory::makeCommonValue(0.1)->class(), // float
    CommonValueFactory::makeCommonValue('a')->class(), // string
    CommonValueFactory::makeCommonValue([])->class(), // array
    CommonValueFactory::makeCommonValue((object) null)->class(), // stdClass
    
    CommonValueFactory::makeCommonValue(new DocumentationNamedExampleClass())->class(), 
    // DocumentationNamedExampleClass
    
    CommonValueFactory::makeCommonValue($anonymous)->class(), // class@anonymous
    CommonValueFactory::makeCommonValue($stream)->class(), // resource (stream)
];

fclose($stream);

$results[] = CommonValueFactory::makeCommonValue($stream)->class(); 
// resource (closed)

$results;
/*
[
    'null',
    'bool',
    'int',
    'float',
    'string',
    'array',
    'stdClass',
    'DocumentationNamedExampleClass',
    'class@anonymous',
    'resource (stream)',
    'resource (closed)',
]
*/
```

## ArrayFactory

Back to [killer features](#killer-features).

### `makeBaseArray()` wraps any value into a predictable iterable array object

Use `BaseArray` when you only need the raw iterable container behavior.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$data = $factory->makeBaseArray('legacy-value');

$data->raw(); // ['legacy-value']
```

### `makeCommonArray()` adds `get()` and `has()` on top of the same normalized data

Use `CommonArray` when the data is mostly flat
and you want value wrappers.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$data = $factory->makeCommonArray([
    'id' => '42',
    'enabled' => '1',
]);

$data->get('id')->int(); // 42
$data->get('enabled')->bool(); // true
```

## CommonArray

Back to [killer features](#killer-features).

### `get()` reads a specific value

`get()` returns a `CommonValueInterface`, so missing keys stay observable.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$data = $factory->makeCommonArray([
    'name' => 'Alice',
    'age' => '31',
]);

$data->get('name')->str(); // 'Alice'
$data->get('age')->int(); // 31
$data->get('missing')->isReal(); // false
```

### `getAny()` returns the first value or a dummy for an empty collection

This is the flat-array equivalent of `AdvancedArray::getAny()`.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$filled = $factory->makeCommonArray([
    'first' => 'A',
    'second' => 'B',
]);
$filled->getAny()->str(); // 'A'

$empty = $factory->makeCommonArray([]);
$empty->getAny()->isReal(); // false
```

### `has()` checks a specific key

Use it when you want a lightweight presence check before
reading the value.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$data = $factory->makeCommonArray([
    0 => 'first',
    'next' => 2,
]);

$data->has(0); // true
$data->has('next'); // true
$data->has('missing'); // false
```

### `hasAny()` checks whether the collection is not empty

Use it when you only need to know whether the collection
contains any item.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$filled = $factory->makeCommonArray([
    'first' => 1,
]);
$filled->hasAny(); // true

$empty = $factory->makeCommonArray([]);
$empty->hasAny(); // false
```

## BaseArray

Back to [killer features](#killer-features).

### `raw()` returns the original normalized array

Use `raw()` when you need the plain array back without wrappers.

```php
use SbWereWolf\LanguageSpecific\Collection\ArrayFactory;

$factory = new ArrayFactory();
$data = $factory->makeBaseArray([
    0 => 'first',
    'index' => 20,
    3 => 'last',
]);

$data->raw();
/*
[
    0 => 'first',
    'index' => 20,
    3 => 'last',
]
*/
```

## Factory helpers

Back to [killer features](#killer-features).

### `makeDummyAdvancedArray()` creates a missing nested-array placeholder

Use it when you need a manual dummy object that behaves
like a missing nested array.

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$dummy = $factory->makeDummyAdvancedArray();

$dummy->isDummy(); // true
$dummy->hasAny(); // false
```

### `makeCommonValue()` wraps any value into a `CommonValueInterface`

Use it when you want the value-wrapper behavior without creating
an array object.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$value = CommonValueFactory::makeCommonValue([
    'region' => 'eu',
]);

$value->array()['region']; // 'eu'
```

### `makeCommonValueAsDummy()` creates a missing-value placeholder

Use it when the missing-state itself is part of the control flow.

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$dummy = CommonValueFactory::makeCommonValueAsDummy();

$dummy->isReal(); // false
$dummy->default('fallback')->str(); // 'fallback'
```

## Native PHP interfaces

Back to [killer features](#killer-features).

These features are convenient, but they are not the main reason to use the
library.

### Read values with `[]`

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    'name' => 'Billing',
    'active' => true,
]);

$data['name']->str(); // 'Billing'
$data['active']->bool(); // true
```

### Iterate with `foreach`

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    'name' => 'Billing',
    'active' => true,
]);

$result = [];
foreach ($data as $key => $value) {
    $result[$key] = $value->asIs();
}

$result; // ['name' => 'Billing', 'active' => true]
```

### Serialize the whole object with `json_encode()`

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    'name' => 'Billing',
    'flags' => [
        'active' => true,
    ],
]);

echo json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
/*
{
    "name": "Billing",
    "flags": {
        "active": true
    }
}
*/
```

## Run tests

```bash
composer test
```

Documentation examples are executable in:

- `tests/unit/DocumentationExamplesTest.php`

## Contacts

```text
Volkhin Nicholas
e-mail ulfnew@gmail.com
phone +7-902-272-65-35
Telegram @sbwerewolf
```

- [Telegram chat with me](https://t.me/SbWereWolf)
- [WhatsApp chat with me](https://wa.me/79022726535)
