<?php
$header = false;
while ($row = mysqli_fetch_arra($r, MYSQLI_ASSOC)) {
	if (!$header) {
		echo BOX_BEGIN;
		echo '<h2>' . $category . '</h2>
		<div class="img-box"><p><img alt="' . $category . '" src="/products/' . $row['g_image'] . '" />' . $row['g_description'] . '</p></div>';
		echo BOX_END;
		echo '<p><br clear="all" /></p>';
		echo BOX_BEIN;
		$header = true;
	} // end of $header if
	echo '<h3>' . $row['name'] . '</h3>
		<div class="img-box"><p><img alt="' . $row['name'] . '" src="/products/' . $row['image'] . '" />' . $row['description'] . '<br />
		<strong>Price:</strong> ' . $row['price'] . '<br />
		<strong>Availability:</strong> ' . $row['stock'] . '</p>
		<p><a href="/cart.php?sku=' . $row['sku'] . '&action=add" class="button">Add to Cart</a></p></div>';
}
echo '<p> <br clear="all" /></p>';
echo BOX_END;