# LanguageSpecific 8.4

Utilities for safe array access and predictable value casting in PHP 8.4+.

## Install

```bash
composer require sbwerewolf/language-specific
```

## Main entry points

- `SbWereWolf\LanguageSpecific\Collection\ArrayFactory`
- `SbWereWolf\LanguageSpecific\AdvancedArrayFactory`
- `SbWereWolf\LanguageSpecific\Value\CommonValueFactory`

Use factories to create handlers.
This way to properly create handlers.
Also you can use `AdvancedArray` and `CommonValue` directly.

## Quick start

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$employee = $factory->makeAdvancedArray([
    'name' => 'Mike',
    'salary' => 19999.99,
]);

echo "The highest paid employee is {$employee->get('name')->str()}"
    . ", with salary of {$employee->get('salary')->int()}$";

// The highest paid employee is Mike, with salary of 19999$
```

## AdvancedArray examples

### `raw()` returns the original array

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    0 => 'first',
    'index' => 20,
    3 => 'last',
]);

var_export($data->raw());
/*
array (
  0 => 'first',
  'index' => 20,
  3 => 'last',
)
*/
```

### `has($key = null)` checks whether an element exists

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([0 => 1, 'next' => 2]);

$data->hasAny(); // true
$data->has(0); // true
$data->has('next'); // true
$data->has('missing'); // false
```

### `get($key = null)` returns a `CommonValueInterface`

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    0 => 'first',
    'index' => 20,
    3 => 'last',
]);

$data->getAny()->asIs(); // 'first'
$data->getAny()->isReal(); // true

$data->get('missing')->asIs(); // null
$data->get('missing')->isReal(); // false

$data->get('index')->int(); // 20
$data->get(3)->str(); // 'last'
```

### `isDummy()` marks a missing nested array

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    'first' => ['A' => 1],
    'next' => ['B' => 2],
]);

$data->pull('first')->isDummy(); // false
$data->pull('missing')->isDummy(); // true
```

### `pull($key = null)` returns a nested `AdvancedArrayInterface`

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    [
        'config' => [
            'env' => ['name' => 'production'],
        ],
    ],
]);

$nested = $data->pull(0)->pull('config')->pull('env');

$nested->isDummy(); // false
$nested->get('name')->str(); // 'production'

$data->pull(0)->pull('missing')->isDummy(); // true
```

### `arrays()` iterates over nested arrays only

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    ['first', 'next', 'last'],
    ['A', 'B', 'C'],
    'tail',
]);

foreach ($data->arrays() as $nested) {
    var_export($nested->raw());
    echo PHP_EOL;
}

/*
array (
  0 => 'first',
  1 => 'next',
  2 => 'last',
)
array (
  0 => 'A',
  1 => 'B',
  2 => 'C',
)
*/
```

### `values()` iterates over non-array elements only

```php
use SbWereWolf\LanguageSpecific\AdvancedArrayFactory;

$factory = new AdvancedArrayFactory();
$data = $factory->makeAdvancedArray([
    ['A', 'B', 'C'],
    'first',
    'next',
    'last',
]);

foreach ($data->values() as $value) {
    echo $value->str() . PHP_EOL;
}

/*
first
next
last
*/
```

## CommonValue examples

### Show (take) values

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$value = CommonValueFactory::makeCommonValue('1.1');

$value->asIs(); // '1.1'
$value->str(); // '1.1'
$value->int(); // 1
$value->double(); // 1.1
$value->bool(); // true
$value->array(); // ['1.1']
```

### `object()` returns the stored object

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$inner = CommonValueFactory::makeCommonValue(1);
$outer = CommonValueFactory::makeCommonValue($inner);
$object = $outer->object();

$object instanceof \SbWereWolf\LanguageSpecific\Value\CommonValue; // true
$object->asIs(); // 1
```

### `isReal()` and `default()` for dummy values

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$dummy = CommonValueFactory::makeCommonValueAsDummy();

$dummy->isReal(); // false
$dummy->asIs(); // null
$dummy->default('fallback')->str(); // 'fallback'

$real = CommonValueFactory::makeCommonValue('real value');
$real->default('fallback')->str(); // 'real value'
```

### `type()` and `class()`

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

CommonValueFactory::makeCommonValue(null)->type(); // 'NULL'
CommonValueFactory::makeCommonValue(false)->type(); // 'boolean'
CommonValueFactory::makeCommonValue(0)->type(); // 'integer'
CommonValueFactory::makeCommonValue(0.1)->type(); // 'double'
CommonValueFactory::makeCommonValue([])->type(); // 'array'

CommonValueFactory::makeCommonValue(null)->class(); // 'null'
CommonValueFactory::makeCommonValue(false)->class(); // 'bool'
CommonValueFactory::makeCommonValue(0)->class(); // 'int'
CommonValueFactory::makeCommonValue(0.1)->class(); // 'float'
CommonValueFactory::makeCommonValue([])->class(); // 'array'
CommonValueFactory::makeCommonValue((object) null)->class(); // 'stdClass'
```

## More examples

See the unit tests for executable usage examples:
- [AdvancedArray](https://github.com/SbWereWolf/language-specific/blob/master/tests/unit/AdvancedArrayTest.php)
- [BaseArray](https://github.com/SbWereWolf/language-specific/blob/master/tests/unit/BaseArrayTest.php)
- [CommonArray](https://github.com/SbWereWolf/language-specific/blob/master/tests/unit/CommonArrayTest.php)
- [CommonValue](https://github.com/SbWereWolf/language-specific/blob/master/tests/unit/CommonValueTest.php)
 
for detail examples of class methods working

## Run tests

```bash
composer test --parallel
```
# Контакты
```
Volkhin Nicholas
e-mail ulfnew@gmail.com
phone +7-902-272-65-35
Telegram @sbwerewolf
```

- [Telegram chat with me](https://t.me/SbWereWolf)
- [WhatsApp chat with me](https://wa.me/79022726535) 
