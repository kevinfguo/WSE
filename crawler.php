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
			$url = 'http://muckrack.com/search/results?q=';
			$url = $url.$name[0];
			for (int i = 1; i < count($name_arr); i++){
				$url = $url.'%20'.$name[i];
			}
			$doc = new DOMDocument();
			$doc -> loadHTMLFile($url);
			$elems = $finder->query("*/div[@class='search-results-header']");
			if (!is_null($elements)){
				foreach ($elements as $element){
					printpre("[".$element->nodeName."]");
					$nodes = $element->childNodes;
					foreach ($nodes as $node){
						printpre($node->nodeValue);
					}
				}
			}
		}
	}
}
?>