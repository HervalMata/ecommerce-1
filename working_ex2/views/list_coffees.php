<?php
include('./includes/product_functions.inc.php');
$header = false;
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	if (!$header) {
		echo '<h2>' . $category . '</h2>
			<div class="img-box">
			<p><img alt="' . $category . '" src="/ecommerce/working_ex2/products/' . $row['image'] . '" />' . $row['decription'] . '</p>
			<p><small>All listed products are currently available.</small>';
			echo '<form action="/ecommerce/working_ex2/cart.php" method="get">
				<input type="hidden" name="action" value="add" />
				<select name="sku">';
				$header = true;
	} // end of $header if
	echo '<option value="' .$row['sku'] . '">' . $row['name'] . get_price($type, $row['price'], $row['sale_price']) . '</option>';
}
echo '</select><input type="submit" value="Add to Cart" class="button" /></p></form></div>';
echo BOX_END;