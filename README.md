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
use SbWereWolf\LanguageSpecific\ArrayHandler;

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

$employee = new ArrayHandler($data);
echo "The highest paid employee is {$employee->get('name')->str()}"
    . ", with salary of {$employee->get('salary')->int()}$";
/*
The highest paid employee is Mike, with salary of 19999$
*/
```
# Library methods of version 7.2
## raw() - returns original array

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler(
    [0 => 'first',
    'index' => 20, 
    3 => 'last',]);
    
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
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler([0=>1]);
$data->has(); // true
// array has at least one index (element)

$data = new ArrayHandler([0=>1]);
$data->has(0); // true
// array has index 0

$data = new ArrayHandler([2=>3]);
$data->has('4'); // false
// array not has index '4'
```
## get($key = null) - Get element by index or without it

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler(
    [0 => 'first',
    'index' => 20, 
    3 => 'last',]);

$data->get()->asIs();
/* 'first' */
$data->get()->wasDefined();
/* true */

$data->get('no-exists')->asIs();
/* NULL */
$data->get('no-exists')->wasDefined();
/* false */

$data->get('index')->asIs();
/* 20 */
$data->get('index')->wasDefined();
/* true */

$data->get(99)->asIs();
/* NULL */
$data->get(99)->wasDefined();
/* false */

$data->get(3)->asIs();
/* 'last' */
$data->get(3)->wasDefined();
/* true */
```
## isUndefined() - flag that exemplar value is undefined

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler(['first' => ['A' => 1], 'next' => ['B'=>2],
    'last' => ['C'=>3],]);

$data->pull('first')->isDummy(); // false
$data->pull('begin')->isDummy(); // true

``` 
## pull($key = null) - get array handler for nested array

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$level4 = [-4 =>
    ['over' => ['and' => ['over' => ['again' => ['for always']]]]]];
$level3 = [-3 => $level4, 'some' => 'other',];
$level2 = [-2 => $level3];
$level1 = [-1 => $level2, 'other' => ['content'], 'any'];
$level0 = [$level1];

$data = new ArrayHandler($level0);

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
## pulling() - iterate through array and get handler for each element

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler([['first', 'next', 'last',],
    ['A','B','C',], ['1','2','3',]]);

foreach ($data->pulling() as $next) {
    /* @var $next ArrayHandler */
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
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler('1.1');
$data->get()->asIs(); // '1.1'
```
## int() - to integer

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler('1.1');
$data->get()->int(); // 1
```
## double() to double

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler('1.1');
$data->get()->double(); // 1.1
```
## str() - to string

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler('1.1');
$data->get()->str(); // '1.1'
```
## bool() - to boolean

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler('1.1');
$data->get()->bool(); // true
```
## array() - to array

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler([1.1]);
$data->get()->array(); // [1.1]
```
## object() - to object

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;
use SbWereWolf\LanguageSpecific\ValueHandler;

$data = new ArrayHandler([new ValueHandler()]);
$value = $data->get()->object();
var_export($value,true);
/*
\SbWereWolf\LanguageSpecific\ValueHandler::__set_state(array(
   '_value' => NULL,
   '_wasDefined' => true,
   '_default' => NULL,
))
*/
```
## has() - flag that value of element was defined on exemplar construction

```php
use SbWereWolf\LanguageSpecific\ArrayHandler;

$data = new ArrayHandler([0=>1]);
$data->get(0)->wasDefined(); // true
// array element with index 0 has value

$data = new ArrayHandler([2=>3]);
$data->get('4')->wasDefined(); // false
// array element with index '4' not has value
```
## type() - get type of value

```php
use SbWereWolf\LanguageSpecific\ValueHandler;

(new ValueHandler(null))->type(); // `NULL`

(new ValueHandler(false))->type(); // `boolean`

(new ValueHandler(0))->type(); // `integer`

(new ValueHandler(0.0))->type(); // `double`

(new ValueHandler('a'))->type(); // `string`

(new ValueHandler([]))->type(); // `array`

(new ValueHandler(new ValueHandler()))->type(); // `object`
```
## asUndefined() - value handler with undefined value

```php
use SbWereWolf\LanguageSpecific\ValueHandlerFactory;

$value = ValueHandlerFactory::makeValueHandlerWithoutValue();
var_export($value);
/*
\SbWereWolf\LanguageSpecific\ValueHandler::__set_state(array(
   '_value' => NULL,
   '_wasDefined' => false,
   '_default' => NULL,
))
*/
```
## default($value = null) - define default value that will be used with undefined value

```php
use SbWereWolf\LanguageSpecific\ValueHandler;

$doNotHasValue = ValueHandlerFactory::makeValueHandlerWithoutValue();
$doNotHasValue->default('default')->str(); // 'default'

$doHasValue = ValueHandlerFactory::makeValueHandler('string');
$doHasValue->default('default')->str(); // 'string'
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
Вольхин Николай
e-mail ulfnew@gmail.com
phone +7-902-272-65-35
Telegram @sbwerewolf
```
[Telegram chat with me](https://t.me/SbWereWolf) 
