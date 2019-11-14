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