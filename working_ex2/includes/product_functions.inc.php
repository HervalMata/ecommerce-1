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
	// grab the first character:
	$type_abbr = substr($sku, 0, 1);
	// grab the remaining characters:
	$pid = substr($sku, 1);
	// validate the type:
	if ($type_abbr === 'C') {
		$type = 'coffee';
	} elseif ($type_abbr === 'G') {
		$type = 'goodies';
	} else {
		$type = NULL;
	}
	// validate the product ID:
	$pid = (filter_var($pid, FILTER_VALIDATE_INT, array('min_range' => 1))) ? $pid : NULL;
	// return the values:
	return array($type, $pid);
} // end of parse_sku() function.

function get_shipping($total = 0) {
	// set the base handling charges:
	$shipping = 3;
	// sate is based upon the total:
	if ($total < 10) {
	$rate = .25;
	} elseif ($total < 20) {
	$rate = .20;
	} elseif ($total < 50) {
	$rate = .18;
	} elseif ($total < 100) {
	$rate = .16;
	} else {
	$rate = .15;
	}
	// calculate the shipping total:
	$shipping = $shipping + ($total * $rate);
	// return the shipping total:
	return $shipping;
} // end of get_shipping() function.