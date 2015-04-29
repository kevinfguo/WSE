<?php
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

$doc = new DOMDocument();
$doc -> loadHTMLFile("http://blogs.reuters.com/robertcyran/page/40");
echo $doc->saveHTML();
?>