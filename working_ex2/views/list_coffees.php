<?php
$header = false;
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	if (!$header) {
		echo '<h2>' . $category . '</h2>
			<div class="img-box">
			<p><img alt="' . $category . '" src="/products/' . $row['image'] . '" />' . $row['decription'] . '</p>
			<p><small>All listed products are currently available.</small>';
			echo '<form action="/cart.php" method="get">
				<input type="hidden" name="action" value="add" />
				<select name="sku">';
				$header = true;
	} // end of $header if
	echo "<option value=\"{$row['sku']}\">{$row['name']}</option>\n";
}
echo '</select><input type="submit" value="Add to Cart" class="button" /></p></form></div>';
echo BOX_END;