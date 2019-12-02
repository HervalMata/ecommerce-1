<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" “http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php // Use a default page title if one wasn’t provided...
if (isset($page_title)) {
echo $page_title;
} else {
echo 'Coffee - Wouldn\'t You Love a Cup Right Now?';
}
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"
/>
<meta name="description" content="Place your description here" />
<meta name="keywords" content="put, your, keyword, here" />
<meta name="author" content="Templates.com - website templates provider" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="/css/superfish.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
<script type="text/javascript" src="/js/ie_png.js"></script>
<script type="text/javascript">
ie_png.fix(‘.png, .logo h1, .box .left-top-corner, .box .right-top-corner, .box .left-bot-corner, .box .right-bot-corner, .box .border-left, .box .border-right, .box .border-top, .box .border-bot, .box .inner, .special dd, #contacts-form input, #contacts-form textarea’);
</script>
<![endif]-->
</head>
<body id="page1">
	<!-- header -->
	<div id="header">
		<div class="container">
		<div class="wrapper">
			<ul class="top-links">
				<li><a href="/ecommerce/working_ex2/index.php" class="first"><img alt="" src="/ecommerce/working_ex2/images/icon-home.gif" /></a></li>
				<li><a href="/ecommerce/working_ex2/cart.php"><img alt="" src="/ecommerce/working_ex2/images/icon-cart.gif" /></a></li>
				<li><a href="/ecommerce/working_ex2/contact.php"><img alt="" src="/ecommerce/working_ex2/images/icon-mail.gif" /></a></li>
				<li><a href="/ecommerce/working_ex2/sitemap.php"><img alt="" src="/ecommerce/working_ex2/images/icon-map.gif" /></a></li>
			</ul>
			<div class="logo">
				<h1><a href="index.php">Coffee</a><span>Wouldn’t you love a cup right now?</span></h1>
			</div>
		</div>
		<ul class="nav sf-menu">
			<!-- MENU -->
				<li class="first"><a href="#">Products</a><ul>
				<li><a href="add_specific_coffees.php">Add Coffee Products</a></li>
				<li><a href="add_other_products.php">Add Non-Coffee Products</a></li>
				<li><a href="add_inventory.php">Add Inventory</a></li>
				</ul></li>
				<li><a href="create_sales.php">Sales</a></li>
				<li><a href="view_orders.php">Orders</a></li>
				<li><a href="#">Customers</a></li>
			<!-- END MENU -->
		</ul>
		</div>
	</div>
	<!-- content -->
	<div id="content">
		<div class="container">
			<div class="inside">