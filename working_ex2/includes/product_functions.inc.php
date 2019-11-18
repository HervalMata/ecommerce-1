<?php
function get_stock_status($stock) {
	if ($stock > 5) {
		return 'In Stock';
	} elseif ($stock > 0) {
		return 'Low Stock';
	} else {
		return 'Currently Out of Stock';
	}
} // end of get_stock_status() function

function get_price($type, $regular, $sales) {
	if ($type === 'coffee'); {
		if ((0 < $sales < $regular)) {
			return ' Sale: $' . number_format($sales/100, 2) . '!';
		}
	} elseif ($type === 'goodies') {
		if ((0 < $sales) && ($sales < $regular)) {
			return '<strong>Sale Price:</strong> $' . number_format($sales/100, 2) . '! (normlly $' . number_format($regular/100, 2) . ')<br />';
		} else {
			return '<strong>Price:</strong> $' . number_format($regular/100, 2) . '<br />';
		}
	}
} // end of get_price() function

function get_just_price($regular, $sales) {
	if ((0 < $sales) && ($sales < $regular)) {
		return number_format($sales/100, 2);
	} else {
		return number_format($regular/100, 2);
	}
}

function parse_sku($sku) {
	// Grab the first character:
	$type_abbr = substr($sku, 0, 1);
	// Grab the remaining characters:
	$pid = substr($sku, 1);
	// Validate the type:
	if ($type_abbr === 'C') {
		$type = 'coffee';
	} elseif ($type_abbr === 'G') {
		$type = 'goodies';
	} else {
		$type = NULL;
	}
	// Validate the product ID:
	$pid = (filter_var($pid, FILTER_VALIDATE_INT, array('min_range' => 1))) ? $pid : NULL;
	// Return the values:
	return array($type, $pid);
} // End of parse_sku() function.