# How to install
```bash
composer require sbwerewolf/language-specific
```
# Features
ArrayHandler with ValueHandler are purpose to **safe access** to array
 elements and **type-safe using** of elements values

With ArrayHandler class you do not need to use 
```php 
array_key_exists()
intval()
boolval()
floatval()

and others
```
With ValueHandler class you get that type exact you want.
# Use-cases
## Get database response with proper types

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$connection = new PDO ($dsn,$login,$password);

$command = $connection->
    prepare('select name,salary from employee'
            . ' ORDER BY salary DESC LIMIT 1');
$command->execute();
$data = $command->fetch(PDO::FETCH_ASSOC);
/*
$data =
    array (
        'name' => 'Mike',
        'salary'=> 19999.99
    );
*/

$employee = new AdvancedArray($data);
echo "The highest paid employee is {$employee->get('name')->str()}"
    . ", with salary of {$employee->get('salary')->int()}$";
/*
The highest paid employee is Mike, with salary of 19999$
*/
```

# Library methods of version 8.4
## raw() - returns original array

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray(
    [0 => 'first',
    'index' => 20, 
    3 => 'last',]
    );
    
$original = $data->raw();

var_export($original);
/*
array (
  0 => 'first',
  'index' => 20,
  3 => 'last',
)
*/
```
## has($key = null) - flag that array has the index (key)

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray([0=>1]);
$data->has(); // true
// array has at least one element

$data = new AdvancedArray([0=>1]);
$data->has(0); // true
// array has element with index 0

$data = new AdvancedArray([2=>3]);
$data->has('4'); // false
// array not has element with index '4'
```
## get($key = null) - Get element by index or without it

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray(
    [0 => 'first',
    'index' => 20, 
    3 => 'last',]);

$data->get()->asIs();
/* 'first' */
$data->get()->isReal();
/* true */

$data->get('no-exists')->asIs();
/* NULL */
$data->get('no-exists')->isReal();
/* false */

$data->get('index')->asIs();
/* 20 */
$data->get('index')->isReal();
/* true */

$data->get(99)->asIs();
/* NULL */
$data->get(99)->isReal();
/* false */

$data->get(3)->asIs();
/* 'last' */
$data->get(3)->isReal();
/* true */
```

## isDummy() - flag that indicates exemplar value is dummy

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray(['first' => ['A' => 1], 'next' => ['B'=>2],
    'last' => ['C'=>3],]);

$data->pull('first')->isDummy(); // false
$data->pull('begin')->isDummy(); // true

``` 

## pull($key = null) - get advanced array for nested array

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$level4 = [-4 =>
    ['over' => ['and' => ['over' => ['again' => ['for always']]]]]];
$level3 = [-3 => $level4, 'some' => 'other',];
$level2 = [-2 => $level3];
$level1 = [-1 => $level2, 'other' => ['content'], 'any'];
$level0 = [$level1];

$data = new AdvancedArray($level0);

$data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->isDummy(); // false

$data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->get()->str(); // 'for always'

$data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4
                )->pull(-5)->isDummy(); // true
```

## arrays() iterate through array and get handler for each nested array

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray([
        ['first', 'next', 'last',],
        ['A','B','C',], 
        ['1','2','3',]
    ]);

foreach ($data->arrays() as $next) {
    /* @var $next AdvancedArray */
    echo PHP_EOL. var_export($next->raw());
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
array (
  0 => '1',
  1 => '2',
  2 => '3',
)
*/
```
## asIs() - Get value as it is

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray('1.1');
$data->get()->asIs(); // "1.1"
```
## int() - to integer

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray('1.1');
$data->get()->int(); // 1
```
## double() to double

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray('1.1');
$data->get()->double(); // 1.1
```
## str() - to string

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray('1.1');
$data->get()->str(); // "1.1"
```
## bool() - to boolean

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray('1.1');
$data->get()->bool(); // true
```
## array() - to array

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

/* Let input string */
$data = new AdvancedArray('1.1');
$data->get()->array(); // [0 => "1.1"]

/* Let input array with string */
$data = new AdvancedArray(['1.1']);
$data->get()->array(); // [0 => "1.1"]
```
## object() - to object

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;
use SbWereWolf\LanguageSpecific\Value\CommonValue;

$data = new AdvancedArray([new CommonValue()]);
$value = $data->get()->object();
var_export($value);
/*
\SbWereWolf\LanguageSpecific\Value\CommonValue::__set_state(array(
   '_value' => NULL,
   '_isReal' => true,
   '_default' => NULL,
))
*/
```

## isReal() - flag that value of element is real (is not dummy)

```php
use SbWereWolf\LanguageSpecific\AdvancedArray;

$data = new AdvancedArray([0=>1]);
$data->get(0)->isReal(); // true
// array element with index 0 has value

$data = new AdvancedArray([2=>3]);
$data->get('4')->isReal(); // false
// array do not have element with index '4' then value is not real
```
## type() - get type of value

```php
use SbWereWolf\LanguageSpecific\Value\CommonValue;

(new CommonValue(null))->type(); // `NULL`

(new CommonValue(false))->type(); // `boolean`

(new CommonValue(0))->type(); // `integer`

(new CommonValue(0.0))->type(); // `double`

(new CommonValue('a'))->type(); // `string`

(new CommonValue([]))->type(); // `array`

(new CommonValue(new CommonValue()))->type(); // `object`
```

## CommonValueFactory::makeCommonValueAsDummy

Create exemplar of CommonValue as dummy

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$value = CommonValueFactory::makeCommonValueAsDummy();
var_export($value);
/*
\SbWereWolf\LanguageSpecific\Value\CommonValue::__set_state(array(
   '_value' => NULL,
   '_isReal' => false,
   '_default' => NULL,
))
*/
```

## default($value = null) - define default value

Default value will be implemented when value is dummy

```php
use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;

$dummy = CommonValueFactory::makeCommonValueAsDummy();
$dummy->default('default')->str(); // "default"

$real = CommonValueFactory::makeCommonValue('real value');
$real->default('default')->str(); // "real value"
```
# Detail info
Refer to 
 - [Array Handler](https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/tests/unit/ArrayHandlerTest.php)
 - [Value Handler](https://github.com/SbWereWolf/language-specific/blob/feature/php7.2/tests/unit/ValueHandlerTest.php)
 
for detail examples of class methods working

# Unit tests
```bash
composer test
```
# Контакты
```
Volkhin Nikolay
e-mail ulfnew@gmail.com
phone +7-902-272-65-35
Telegram @sbwerewolf
```

- [Telegram chat with me](https://t.me/SbWereWolf)
- [WhatsApp chat with me](https://wa.me/79022726535) 
