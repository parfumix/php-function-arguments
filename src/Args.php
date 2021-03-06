<?php namespace Argument;

use Argument\Contracts\Argumentable;
use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use Illuminate\Validation\Factory;
use Iterator;
use IteratorAggregate;

class Args implements Argumentable, ArrayAccess, Iterator, IteratorAggregate, Countable {

	protected $rules = array();

	protected $items = array();

	/**
	 * Create new args instance ..
	 *
	 * @param null $values
	 * @param null $rules
	 * @return Args
	 */
	public static function create($values = null, $rules = null) {
		$values = (array)$values;
		$rules = (array)$rules;

		$self = new self;
		$self->rules($rules);

		array_walk($values, function ($value, $key) use (&$self) {
			$self->set($key, $value);
		});

		return $self;
	}

	/**
	 * Set the rules .
	 *
	 * @param array $rules
	 */
	public function rules(array $rules = array()) {
		$this->rules = $rules;
	}

	/**
	 * Set key .
	 *
	 * @param $key
	 * @param $value
	 */
	public function set($key, $value) {
		$this->items[$key] = $value;
	}

	/**
	 * Get key .
	 *
	 * @param $key
	 * @return mixed
	 */
	public function get($key) {
		return $this->items[$key];
	}

	/**
	 * Perform validation .
	 *
	 * @param null $key
	 * @param callable $closure
	 * @return bool
	 */
	public function validate($key = null, Closure $closure = null) {
		if(! $this->rules)
			return true;

		$validator = Factory::make($this->items, $this->rules);

		$isValid = false;
		if( $validator->passes() )
			$isValid = true;

		if( $closure )
			$closure($validator->failed());

		return $isValid;
	}

	
	public function __invoke($key = null) {
		return $this->valid($key);
	}

	public function __get($key) {
		return $this->items[$key];
	}

	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Interface implementations                                          *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 */

	public function offsetExists($key) {
		return array_key_exists($key, $this->items);
	}

	public function offsetGet($key) {
		return $this->items[$key];
	}

	public function offsetSet($key, $value) {
		if (is_null($key)) {
			$this->items[] = $value;
		} else {
			$this->items[$key] = $value;
		}
	}

	public function offsetUnset($key) {
		unset($this->items[$key]);
	}

	public function current() {
		return current($this->items);
	}

	public function next() {
		return next($this->items);
	}

	public function key() {
		return key($this->items);
	}

	public function valid() {
		return key($this->items) !== null;
	}

	public function rewind() {
		return reset($this->items);
	}

	public function count() {
		return count($this->items);
	}

	public function getIterator() {
		return new ArrayIterator($this->items);
	}
}
