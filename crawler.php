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
			$url = 'http://muckrack.com/search/results?q=';
			$url = $url.$this->name_arr[0];
			for ($i = 1; $i < count($this->name_arr); $i++){
				$url = $url.'%20'.$this->name_arr[$i];
			}
			$doc = new DOMDocument();
			@$doc->loadHTMLFile($url);
			$finder = new DOMXPath($doc);
			$elements = $finder->query("//*[contains(@class,'person-details-name')]//a");
			foreach ($elements as $element){
				$results[] = array('author' => $element->nodeValue,
					'link' => "http://muckrack.com".$element->getAttribute("href")."/articles");
			}
		}
		else if ($website == 'nyt'){
			ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
			$url = 'http://topics.nytimes.com/top/reference/timestopics/people/index.html';
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
						$results[] = array('author' => $element->nodeValue, 'link' => $element->getAttribute("href"));
					}
				}
			}
		}else if ($website == 'latimes'){
			ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
			$url = 'http://www.latimes.com/about/la-editorial-staff-directory-htmlstory.html';
			$doc = new DOMDocument();
			@$doc->loadHTMLFile($url);
			$finder = new DOMXPath($doc);
			$elements = $finder->query("//*[contains(@class,'                      trb_article_page_body')]//p//a");
			foreach ($elements as $element){
				$laname = $element->nodeValue;
					$found = true;
					foreach($this->name_arr as $parts){
						if (strpos($laname, $parts) === FALSE){
							$found = false;
							break;
						}
					}
					if ($found){
						$results[] = array('author' => $element->nodeValue, 'link' => $element->getAttribute("href"));
					}
			}
		}
		return $results;	
	}

	function obtain_articles($URL){
		ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
		$website = parse_url($URL);
		printpre($website["host"]);
		$articles = array();
		if ($website['host'] == "muckrack.com"){
			$doc = new DOMDocument();
			@$doc->loadHTMLFile($URL);
			$finder = new DOMXPath($doc);
			$elements = $finder->query("//*[contains(@class,'news-story')]//h3//a");
			foreach ($elements as $element){
				$articles[] = array('link' => $element->getAttribute("href"), 'title' => $element->nodeValue);
			}
			//printpre($articles);
		}else if ($website['host'] == "topics.nytimes.com"){
			$doc = new DOMDocument();
			@$doc->loadHTMLFile($URL);
			$finder = new DOMXPath($doc);
			$elements = $finder->query("//*[contains(@class,'story clearfix')]//h4//a");
			foreach ($elements as $element){
				$articles[] = array('link' => $element->getAttribute("href"), 'title' => $element->nodeValue);
			}
		}else if ($website['host'] == "www.latimes.com"){
			$doc = new DOMDocument();
			@$doc->loadHTMLFile($URL);
			$finder = new DOMXPath($doc);
			$elements = $finder->query("//*[contains(@class,'trb_outfit_group_list_item_figure')]");
			foreach ($elements as $element){
				$articles[] = array('link' => 'http://www.latimes.com'.$element->getAttribute("href"));
			}
		}
		return $articles;
	}
}
?>