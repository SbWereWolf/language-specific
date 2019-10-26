# Features
ArrayHandler with ValueHandler are purpose to **safe access** to array
 elements and **type-safe using** of elements values

With ArrayHandler class you do not need to use 
```php 
array_key_exists()
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
   'data' => 
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
  )
*/
$names = new ArrayHandler($data);
$names->simplify();
/*
   $names->data => 
  array (
    0 => 'Mike',
    1 => 'Tom',
    2 => 'Jerry',
    3 => 'Mary'
  )
*/
echo 'Employes with salary greater than 10000$:' . PHP_EOF;
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
   $data => 
  array (
    'name' => 'Jerry',
    'salary' => 19999.99
  )
*/
$employee = new ArrayHandler($data);
echo "The highest paid employee is {$employee->get('name')->str()}"
   . ", with salary of {$employee->get('salary')->int()}$"
/*
The highest paid employee is Jerry, with salary of 19999$
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

$data->get('no-exists')->asIs();
/* NULL */
$data->get('no-exists')->isNull();
/* true */

$data->get('index')->asIs();
/* 20 */
$data->get('index')->isNull();
/* false */

$data->get(99)->asIs();
/* NULL */
$data->get(99)->isNull();
/* true */

$data->get(3)->asIs();
/* 'last' */
```
## simplify() - reduce array nesting
```php
$data = new ArrayHandler([0, [1,2], [[3,4],[5,6]], null,]);
var_export($data,true);
/*
LanguageSpecific\ArrayHandler::__set_state(array(
   'data' => 
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
   'data' => 
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
$data = new ArrayHandler(new ArrayHandler());
$data->get()->object();
var_export($value,true)
/*
LanguageSpecific\ValueHandler::__set_state(array(
   'value' => NULL,
   'isNull' => true,
))
*/
```
## isNull() - check value is NULL
```php
$data = new ArrayHandler(null);
$data->get()->isNull(); // true

$data = new ArrayHandler(1);
$data->get()->isNull(); // false
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
# Detail info
Refer to [tests/unit/ArrayHandlerTest.php](https://github.com/SbWereWolf/language-specific/blob/develop/tests/unit/ArrayHandlerTest.php)
and [tests/unit/ValueHandlerTest.php](https://github.com/SbWereWolf/language-specific/blob/develop/tests/unit/ValueHandlerTest.php)
for detail examples of use-cases

# How to install
```bash
composer require sbwerewolf/language-specific
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
[Web chat with me](https://t.me/SbWereWolf) 
