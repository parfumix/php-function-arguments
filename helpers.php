<?php

/**
 * Create an instance of argument ..
 */
if (!function_exists('args')) {
	function args($rules = null, $values = null) {
		return Argument\Args::create($rules, $values);
	}
}
