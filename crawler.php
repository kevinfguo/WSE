<?php
require_once 'helper.php';
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

class Crawler{

	private $name = '';
	private $name_arr;

	function setQuery($qname){
		$this->name = $qname;
		$this->name_arr = explode(" ", $qname);
	}

	function search($website){
		$results = array();
		if ($website == 'muckrack'){
			ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
			//$doc = new DOMDocument();
			//$doc -> loadHTMLFile("http://muckrack.com/gary-levin/articles");
			$url = 'http://muckrack.com/search/results?q=';
			//printpre($this->name_arr);
			$url = $url.$this->name_arr[0];
			for ($i = 1; $i < count($this->name_arr); $i++){
				$url = $url.'%20'.$this->name_arr[$i];
			}
			//printpre($url);
			$doc = new DOMDocument();
			@$doc->loadHTMLFile($url);
			$finder = new DOMXPath($doc);
			$elements = $finder->query("//*[contains(@class,'person-details-name')]//a");
			foreach ($elements as $element){
				//echo "<br>".$element->nodeValue;
				//echo "<br>".$element->getAttribute("href");
				$results['author'][] = $element->nodeValue;
				$results['link'][] = "http://muckrack.com".$element->getAttribute("href")."/articles";
			}
		}
		else if ($website == 'nyt'){
			ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
			$url = 'http://topics.nytimes.com/top/reference/timestopics/people/index.html';
			//printpre($url);
			$doc = new DOMDocument();
			@$doc->loadHTMLFile($url);
			$finder = new DOMXPath($doc);
			foreach ($doc->getElementsByTagName('td') as $tbody){
				$elements = $finder->query("a", $tbody);
				foreach ($elements as $element){
					$nytname = $element->nodeValue;
					$found = true;
					foreach($this->name_arr as $parts){
						if (strpos($nytname, $parts) === FALSE){
							$found = false;
							break;
						}
					}
					if ($found){
						//echo "<br>".$element->getAttribute("href");
						//echo "<br>".$element->nodeValue;
						$results['author'][] = $element->nodeValue;
						$results['link'][] = $element->getAttribute("href");
					}
				}
			}
		}
		return $results;	
	}
}
?>