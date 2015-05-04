<!DOCROOT>
<html>

<?php
require_once 'helper.php';
require_once 'crawler.php';
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$res_nums = array();
	$crawler = new Crawler();
	$crawler->setQuery($_POST["fname"]);
	$res = $crawler->search('nyt');
	$res_nums[] = count($res);
	$res2 = $crawler->search('latimes');
	foreach ($res2 as $newres){
		$res[] = $newres;
	}
	$res_nums[] = count($res);
	$res2 = $crawler->search('muckrack');
	foreach ($res2 as $newres){
		$res[] = $newres;
	}
	$res_nums[] = count($res);
	//printpre($res);
	//printpre($res_nums);
	?>
	<form action="analysis.php" method="POST">
		<?php for($i=0; $i < count($res); $i++){ 
			//if (in_array($i, $res_nums)) echo 'website';
		?>
			<input type="radio" name="journalist" value="<?php echo $res[$i]['link']; ?>"><?php echo $res[$i]['author']; ?>
			<br>
		<?php } ?>
		<input type="submit" value="Select one!">
	</form>
<?php 
}else{
	printpre("Failure!");
}
?>

</html>