<?php

	ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);
	require_once 'helper.php';
?>
<!DOCROOT>
<html>
	<form action="results.php" method="POST">
		Name: <input type="text" name="fname">
		<br>
		<input type="submit" value="Submit">
	</form>
</html>
