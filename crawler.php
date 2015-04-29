<?php
require_once 'helper.php';
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

class Crawler{

	private $name = '';
	private $name_arr;

	function setQuery($qname){
		$name = $qname;
		$name_arr = explode(" ", $qname);
		printpre($name);
		printpre($name_arr);
	}
	function crawl($website){
		if ($website == 'muckrack'){
			$url = 'http://muckrack.com/search/results?q='

		}
	}
}
?>