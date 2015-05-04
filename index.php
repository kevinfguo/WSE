<?php

	ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);
	require_once 'helper.php';
?>
<!DOCROOT>
<html>
	<head>
	<title>Journalist Agenda Analyzer</title>
	</head>

	<p>Enter a journalist's name! Example: Vindu Goel</p>
	<form action="results.php" method="POST">
		Name: <input type="text" name="fname">
		<br><br>
		<input type="submit" value="Submit">
	</form>
</html>
