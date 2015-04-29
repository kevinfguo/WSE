<?php
require_once 'helper.php';
require_once 'crawler.php';
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	printpre("Success!");
	printpre($_POST["fname"]);
	printpre($_POST["lname"]);
	$crawler = new Crawler();
	$crawler->setQuery($_POST["fname"]);
}else{
	printpre("Failure!");
}
?>