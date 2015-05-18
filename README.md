# Argument helper

Argument helper is an class helper which can help wich help you to reduce the arguments of php function and easy convert it to class and can extracted and validated ..

```php
    // From ..
    public function example($arg1, $arg2, $arg3, $arg4 = null, $arg5 = array());
    // To ..
    public function example(Argumentable $args);
````
### Instalation
You can use the `composer` package manager to install. Either run:

    $ php composer.phar require kartik-v/bootstrap-star-rating "dev-master"

or add:

    "kartik-v/bootstrap-star-rating": "dev-master"

to your composer.json file

### Usage

You can easy create an instance of arugments by using args helper functions
```php
$args = args();

// or if you want to pass some values and rules
$args = args($values = array(), $rules = array());

// or you can use ::create static functions
$args = Argument::create($values = array(), $rules = array());
```

Argument implements php interfaces like "Argumentable, ArrayAccess, Iterator, IteratorAggregate, Countable" so you can easy
iterate by arguments or access elements as array or count your arguments

```php
$args = args($values = array(
    'key' => 'value'
));

// to access an arguments you can use
$args['key']
// or
$args->get('key')

// counting arguments
count($args)
```

### Validation

You can easy validate arguments using validation function or call object as function (using __invoke)

```php
$args = args();
$args->set('key', 'value');

// You can validate your args before
if( ! $args->validate(function($failedFields) {
    // you can do whetever with failed fields ..
}) )

class Example {
    public function needParams(Argumentable $args) {
        // Or you can validate here .
        if( ! $args->validate(function($failedFields) {
            // you can do whetever with failed fields ..
        }) )
    }
}
```
