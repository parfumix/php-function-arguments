# php-function-arguments

// Example of usage ..

$arguments = args();
$arguments->set('name', 'value1');
$arguments->set('name', 'value1');

// Perform validation ..
$arguments();


// Get option
$arguments->get('name');


class Example {

	public function render(Argumentable $args) {
		$args->get('name');
		// or
		$args->name;
	}
}
