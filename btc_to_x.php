#!/usr/bin/php
<?php
define("ME", $argv[0]);
ini_set("date.timezone", "America/Mexico_City");
if (sizeOf($argv)<=1){
	echo "Usage:".PHP_EOL;
	echo "\t".ME." {FIAT}".PHP_EOL;
	echo "\t".ME." USD".PHP_EOL;
	exit;
}
require_once("classes/curl_get_contents/curl_get_contents.php");

$fiat = strtoupper(trim($argv[1]));
$tmpFile = tempnam("/tmp", "stex");
$o = curl_get_contents('https://blockchain.info/es/ticker');
if (trim($o)==""){
	echo "empty response".PHP_EOL;
exit(1);
}
$d = json_decode($o);
$i = $d->$fiat;
switch(@$argv[2]){
case "buy":
case "sell":
case "last":
case "15m":
	if (@$argv['3']==null)
		echo "BTC $argv[2] -> ".$i->$argv[2]." $fiat".PHP_EOL;
	else
		echo $i->$argv[2].PHP_EOL;
	break;
default:
	print_r($i);
	break;
}

exit;
