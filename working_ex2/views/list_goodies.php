<?php
include('./includes/product_functions.inc.php');
$header = false;
while ($row = mysqli_fetch_arra($r, MYSQLI_ASSOC)) {
	if (!$header) {
		echo BOX_BEGIN;
		echo '<h2>' . $category . '</h2>
		<div class="img-box"><p><img alt="' . $category . '" src="/ecommerce/working_ex2/products/' . $row['g_image'] . '" />' . $row['g_description'] . '</p></div>';
		echo BOX_END;
		echo '<p><br clear="all" /></p>';
		echo BOX_BEIN;
		$header = true;
	} // end of $header if
	echo '<h3>' . $row['name'] . '</h3>
		<div class="img-box"><p><img alt="' . $row['name'] . '" src="/ecommerce/working_ex2/products/' . $row['image'] . '" />' . $row['description'] . '<br /> . get_price($type, $row['price'], $row['sale_price']) . <strong>Availability:</strong> ' . get_stock_status($row['stock']) . '</p>
		<p><a href="/ecommerce/working_ex2/cart.php?sku=' . $row['sku'] . '&action=add" class="button">Add to Cart</a></p></div>';
}
echo '<p> <br clear="all" /></p>';
echo BOX_END;