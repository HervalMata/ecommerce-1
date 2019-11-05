<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php
	if (isset($page_title)) { 
			echo $page_title; 
	} else { 
			echo 'Knowledge is Power: And It Pays to Know'; 
	} 
	?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">

  </head>

  <body>

    <!-- Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="navbar navbar-fixed-top">
        <div class="container">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Knowledge is Power</a>
          <div class="nav-collapse collapse">
            <ul class="nav navbar-nav">
				    <?php
            $pages = array (
              'Home' => 'index.php',
              'About' => '#',
              'Register' => 'register.php'
            );
            $this_page = basename($_SERVER['PHP_SELF']);
            foreach ($pages as $k => $v) {
              echo '<li';
              if ($this_page == $v) echo ' class="active"';
              echo '><a href="' . $v . '">' . $k . '</a></li>';
            } // End of foreach
            if (isset($_SESSION['user_id'])) {
              echo '<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown-menu">
                <li><a href="logout.php">Logout</a></li>
                <li><a href="renew.php">Renew</a></li>
                <li><a href="change_password.php">Change Password</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="recommendations.php">Recommendations</a></li>
              </ul>
            </li>';
            }
            if (isset($_SESSION['user_admin'])) {
              echo '<li class="dropdown
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               Admin <b class="caret"></b></a>
                <ul class ="dropwdown-menu">
                  <li><a href="add_page.php">Add Page</a></li>
                  <li><a href="add_pdf.php">Add PDF</a></li>
                </ul>
              </li>';
            }
            ?>

            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/container-->
      </div><!--/navbar-->

      <!-- Begin page content -->
      <div class="container">
	
		<div class="row">
			
			<div class="col-3">
				<h3 class="text-success">Content</h3>
			<div class="list-group">
        <?php
        $q = 'SELECT * FROM categories ORDER BY category';
        $r = mysqli_query($dbc, $q);
        while (list($id, $category) = mysqli_fetch_array($r, MYSQLI_NUM)) {
          echo '<a href="category.php?id=' . $id . '"
              class="list-group-item" title="' . $category . '">' . 
              htmlspecialchars($category) . ' </a>';
        }
        ?>
			</div><!--/list-group-->
      
      <?php
      if (!isset($_SESSION['user_id'])) {
        require('includes/login_form.inc.php');
      }
      ?>

      </div><!--/col-3-->
		  
			
		  <div class="col-9">