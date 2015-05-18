# php-function-arguments

# Example of usage ..

```php
$arguments = args();
$arguments->set('name', 'value1');
$arguments->set('name', 'value1');

// Perform validation ..
$arguments();
```


```php
class Example {

	public function render(Argumentable $args) {
		$args->get('name');
		// or
		$args->name;
	}
}
```
