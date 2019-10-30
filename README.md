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
## Simplify data base response and output data as is:
```php
$connection = new PDO ($dsn,$login,$password);

$command = $connection->
            prepare('select name from employee where salary > 10000');
$command->execute();
$data = $command->fetchAll(PDO::FETCH_ASSOC);
/*
$data =
    array (
        0 =>
            array (
                'name' => 'Mike',
            ),
        1 =>
            array (
                'name' => 'Tom',
            ),
        2 =>
            array (
                'name' => 'Jerry',
            ),
        3 =>
            array (
                'name' => 'Mary',
            )
    );
*/
$names = new ArrayHandler($data);
$result = $names->simplify();

echo var_export($result,true);
/*
LanguageSpecific\ArrayHandler::__set_state(array(
   '_data' => 
  array (
    0 => 'Mike',
    1 => 'Tom',
    2 => 'Jerry',
    3 => 'Mary',
  ),
))
*/
echo 'Employes with salary greater than 10000$:' . PHP_EOL;
foreach ($names->next() as $employee) {
    echo $employee->asIs() . PHP_EOL;
}
/*
Employes with salary greater than 10000$:
Mike
Tom
Jerry
Mary
*/
```
## Get data base response with proper types
```php
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
# Library methods
## next() - Iterate through array elements
```php
$data = new ArrayHandler(['first', 'next', 'last',]);

foreach ($data->next() as $item) {
    echo $item->asIs() . PHP_EOL;
}
/*
output are:

first
next
last
*/
```
## get() - Get element
```php
$data = new ArrayHandler(
    [0 => 'first',
    'index' => 20, 
    3 => 'last',]);

$data->get()->asIs();
/* 'first' */
$data->get()->has();
/* true */

$data->get('no-exists')->asIs();
/* NULL */
$data->get('no-exists')->has();
/* false */

$data->get('index')->asIs();
/* 20 */
$data->get('index')->has();
/* true */

$data->get(99)->asIs();
/* NULL */
$data->get(99)->has();
/* false */

$data->get(3)->asIs();
/* 'last' */
$data->get(3)->has();
/* true */
```
## simplify() - reduce array nesting
If element is array then only first array element will remain present
```php
$data = new ArrayHandler([0, [1,2], [[3,4],[5,6]], null,]);
var_export($data,true);
/*
LanguageSpecific\ArrayHandler::__set_state(array(
   '_data' => 
  array (
    0 => 0,
    1 => 
    array (
      0 => 1,
      1 => 2,
    ),
    2 => 
    array (
      0 => 
      array (
        0 => 3,
        1 => 4,
      ),
      1 => 
      array (
        0 => 5,
        1 => 6,
      ),
    ),
    3 => NULL,
  ),
))
*/
$data->simplify();
var_export($data,true);
/*
LanguageSpecific\ArrayHandler::__set_state(array(
   '_data' => 
  array (
    0 => 0,
    3 => NULL,
    4 => 1,
    5 => 
    array (
      0 => 3,
      1 => 4,
    ),
  ),
))
*/
```
## has() - flag that array has the index (key)
```php
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
## pull($key = null) - get array handler for nested array
```php
$level4 = [-4 =>
    ['over' => ['and' => ['over' => ['again' => [true]]]]]];
$level3 = [-3 => $level4, 'some' => 'other',];
$level2 = [-2 => $level3];
$level1 = [-1 => $level2, 'other' => ['content'], 'any'];
$level0 = [$level1];

$data = new ArrayHandler($level0);

$data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->isUndefined(); // true

$data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4)->pull('over')
                ->pull('and')->pull('over')->pull('again')
                ->get()->bool(); // true

$data->pull(0)->pull(-1)->pull(-2)
                ->pull(-3)->pull(-4
                )->pull(-5)->isUndefined(); // false
```
## asIs() - Get value as it is
```php
$data = new ArrayHandler('1.1');
$data->get()->asIs(); // '1.1'
```
## int() - to integer
```php
$data = new ArrayHandler('1.1');
$data->get()->int(); // 1
```
## double() to double
```php
$data = new ArrayHandler('1.1');
$data->get()->double(); // 1.1
```
## str() - to string
```php
$data = new ArrayHandler('1.1');
$data->get()->str(); // '1.1'
```
## bool() - to boolean
```php
$data = new ArrayHandler('1.1');
$data->get()->bool(); // true
```
## array() - to array
```php
$data = new ArrayHandler([1.1]);
$data->get()->array(); // [1.1]
```
## object() - to object
```php
$data = new ArrayHandler(new ValueHandler());
$value = $data->get()->object();
var_export($value,true);
/*
LanguageSpecific\ValueHandler::__set_state(array(
   '_value' => NULL,
   '_has' => true,
   '_default' => NULL,
))
*/
```
## has() - flag that value of element was defined on exemplar construction
```php
$data = new ArrayHandler([0=>1]);
$data->get(0)->has(); // true
// array element with index 0 has value

$data = new ArrayHandler([2=>3]);
$data->get('4')->has(); // false
// array element with index '4' not has value
```
## type() - get type of value
```php
(new ValueHandler(null))->type(); // `NULL`

(new ValueHandler(false))->type(); // `boolean`

(new ValueHandler(0))->type(); // `integer`

(new ValueHandler(0.0))->type(); // `double`

(new ValueHandler('a'))->type(); // `string`

(new ValueHandler([]))->type(); // `array`

(new ValueHandler(new ValueHandler()))->type(); // `object`
```
## asUndefined() - value handler with undefined value (it is singleton)
```php
$value = ValueHandler::asUndefined();
var_export($value,true);
/*
LanguageSpecific\ValueHandler::__set_state(array(
   '_value' => NULL,
   '_has' => false,
   '_default' => NULL,
))
*/
```
## with() - define default value that will be used with undefined value
```php
ValueHandler::asUndefined()->with('default')->str(); // 'default'
(new ValueHandler('string'))->with('default')->str(); // 'string'
```
# Detail info
Refer to 
 - [tests/unit/ArrayHandlerTest.php](https://github.com/SbWereWolf/language-specific/blob/feature/php5.6/tests/unit/ArrayHandlerTest.php)
 - [tests/unit/ValueHandlerTest.php](https://github.com/SbWereWolf/language-specific/blob/master/tests/unit/ValueHandlerTest.php)
 
for detail examples of class methods working

# How to install
```bash
composer require sbwerewolf/language-specific ^5.6
```
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
