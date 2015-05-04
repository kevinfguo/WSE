<?php
	ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);
	require_once 'helper.php';
	require_once 'crawler.php';
	require_once 'alchemyapi_php/alchemyapi.php';
	$alchemyapi = new AlchemyAPI();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	//printpre($_POST["journalist"]);
	$crawler = new Crawler();
	$articles = $crawler->obtain_articles($_POST["journalist"]);
	//printpre("Success!");
	/*
	$results = array();
	$options = array();
	$options['sentiment'] = 1;
	foreach ($articles as $article){
		$response = $alchemyapi->keywords("url", $articles[0]['link'], $options);
		$results[] = $response;
	}
	printpre(json_encode($results));
	*/
	//$response = $alchemyapi->keywords("url", $articles[0]['link'], null);
	//printpre($response);
}else {
	printpre("Failure!");
}
?>
