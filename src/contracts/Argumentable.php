<?php

interface Argumentable {

	public function set($key, $value);

	public function get($key);

	public function rules(array $rules = array());

	public function validate();
}
