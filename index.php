<?php

	ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);
	require_once 'helper.php';
	require_once 'alchemyapi_php/alchemyapi.php';
	$alchemyapi = new AlchemyAPI();
?>
<!DOCROOT>
<html>
	<form action="results.php" method="POST">
		First name: <input type="text" name="fname">
		<br>
		Last name: <input type="text" name="lname">
		<br>
		<input type="submit" value="Submit">
	</form>
</html>
