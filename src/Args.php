<?php namespace Argument;

use Argument\Contracts\Argumentable;
use ArrayAccess;
use Countable;
use Iterator;
use IteratorAggregate;

class Args implements Argumentable, ArrayAccess, Iterator, IteratorAggregate, Countable {

	protected $rules;

	protected $items;

	public static function create($rules = null, $values = null) {
		$values = (array)$values;
		$rules = (array)$rules;

		$self = new self;
		$self->rules($rules);

		array_walk($values, function ($value, $key) use (&$self) {
			$self->set($key, $value);
		});

		return $self;
	}

	public function rules(array $rules = array()) {
		$this->rules = $rules;
	}

	public function set($key, $value) {
		$this->items[$key] = $value;
	}

	public function get($key) {
		return $this->items[$key];
	}

	public function validate() {
		return $this();
	}

	public function __invoke() {
		array_walk($this->rules, function ($rule) {
			$validations = explode(',', $rule);

			array_walk($validations, function ($validation) use ($rule) {
				$func = sprintf('is', ucfirst($validation));
				if (! method_exists($this, $func))
					return false;

				if (! $this->$func($this->$rule))
					return false;
			});
		});
	}

	public function __get($key) {
		return $this->items[$key];
	}


	/**
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Validation functions                                               *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 */

	protected function isRequired($value) {
		return isset($value) ? true : false;
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
