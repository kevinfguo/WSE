<!DOCROOT>
<html>
<head>
	<title>Journalist Agenda Analyzer</title>
</head>

<?php
require_once 'helper.php';
require_once 'crawler.php';
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$res_nums = array();
	$websites = array("Muckrack", "LA Times", "NY Times");
	$crawler = new Crawler();
	$crawler->setQuery($_POST["fname"]);
	$res = $crawler->search('nyt');
	$res_nums[] = array('popnum' => 0, 'website' => array_pop($websites));
	$res_nums[] = array('popnum' => count($res), 'website' => array_pop($websites));
	$res2 = $crawler->search('latimes');
	foreach ($res2 as $newres){
		$res[] = $newres;
	}
	$res_nums[] = array('popnum' => count($res), 'website' => array_pop($websites));
	$res2 = $crawler->search('muckrack');
	foreach ($res2 as $newres){
		$res[] = $newres;
	}
	$temp = array_shift($res_nums);
	?>
	<div>
	<h3>Select a journalist</h3>
	<form action="analysis.php" method="POST">
		<?php for($i=0; $i < count($res); $i++){ 
			while ($temp['popnum'] == $i) {
				
				echo '<b>'.$temp['website'].' Results: </b><br>';
				if (empty($res_nums)) break;
				$temp = array_shift($res_nums);
			}
		?>
			<input type="radio" name="journalist" value="<?php echo $res[$i]['link']; ?>"><?php echo $res[$i]['author']; ?>
			<br>
		<?php } ?>
		<input type="submit" value="Submit">
	</form>
	</div>
<?php 
}else{
	printpre("Failure!");
}
?>

</html>