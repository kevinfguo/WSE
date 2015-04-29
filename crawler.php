<?php
require_once 'helper.php';
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

class Crawler{

	private $name = '';

	function setQuery($qname){
		$name = $qname;
		printpre($name);
	}
	function crawl($website){

	}
}
?>