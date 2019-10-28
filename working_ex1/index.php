<?php
require('./includes/config.inc.php');
require(MYSQL);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include('./inlcudes/login.inc.php');
}
include('./includes/header.html');
?>
<h1>Welcome</h1>
<p class="lead">Welcome to Knowledge is Power, a site dedicated to keeping you up-to-date on the Web security and programming information you need to know. Blah, blah, blah. Yadda, yadda, yadda.</p>
<?php
include('./includes/footer.html');
?>
