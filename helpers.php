<?php

/**
 * Create an instance of argument ..
 */
if (!function_exists('args')) {
	function args($values = null, $rules = null) {
		return Argument\Args::create($values, $rules);
	}
}
