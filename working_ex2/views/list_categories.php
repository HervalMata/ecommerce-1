<?php
echo BOX_BEGIN;
echo '<ul class="items-list">';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	echo '<li><h3>' . $row['category'] . ' </h3>
	<p><img alt="' . $row['category'] . '" src="/ecommerce/working_ex2/products/' . $row['image'] . '" />' . $row['description'] . '<br />
	<a href="/ecommerce/working_ex2/browse/' . $type . '/' . urlencode($row['category']) . '/' . $row['id'] . '" class="h4">View All ' . $row['category'] . ' Products</a></p>
	</li>';
}
echo '</ul>';
echo BOX_END;