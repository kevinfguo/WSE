<html>
<head>
	<title>Journalist Agenda Analyzer</title>
</head>

<?php
	ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);
	require_once 'helper.php';
	require_once 'crawler.php';
	require_once 'alchemyapi_php/alchemyapi.php';
	$alchemyapi = new AlchemyAPI();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$crawler = new Crawler();
	$articles = $crawler->obtain_articles($_POST["journalist"]);
	$results = array();
	$options = array();
	$options['sentiment'] = 1;
	$options['keywordExtractMode'] = 'strict';
	$num_arts = 0;
	foreach ($articles as $article){
		$response = $alchemyapi->keywords("url", $article['link'], $options);
		$results[] = $response;
		$num_arts++;
		if ($num_arts >= 10) break;
	}
	$keywords = array();
	$n = 0;
	foreach($results as $analysis){
		$m = 0;
		foreach($analysis['keywords'] as $keyword){
			if (isset($keywords[$keyword['text']])){
				$keywords[$keyword['text']]['count'] += 1;
				if (isset($keyword['sentiment']['score'])){
					$keywords[$keyword['text']]['sent'] += $keyword['sentiment']['score'];
				}
				$keywords[$keyword['text']]['articles'][] = $analysis['url'];
			}else{
				if (isset($keyword['sentiment']['score'])){
					$keywords[$keyword['text']] = 
						array('count' => 1, 
							'sent' => $keyword['sentiment']['score'],
							'articles' => array($analysis['url']));
				}else{
					$keywords[$keyword['text']] = 
						array('count' => 1, 
							'sent' => 0,
							'articles' => array($analysis['url']));
				}
			}
		$m++;
		if ($m >= 10) break;
		}
	}
	uasort($keywords,'cmp');
	echo '<h4>Top 10 key topics for your journalist based on their most recent articles</h4>';
	foreach($keywords as $key=>$value){
		echo '<div>';
		echo '<h4>'.$key.'</h4>';
		echo '<p>Based on '.$value['count'].' articles, the author has written '.opinion_val($value['sent']/$value['count']).' ('.round($value['sent']/$value['count'],4).') about '.$key.'<br>';
		foreach($value['articles'] as $article){
			echo $article.'<br>';
		}
		echo '</p></div>';
		$n++;
		if ($n >= 10) break;
	}
}else {
	printpre("Failure!");
}
?>
</html>
