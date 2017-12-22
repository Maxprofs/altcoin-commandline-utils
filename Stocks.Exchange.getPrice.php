#!/usr/bin/php
<?php
define("ME", $argv[0]);
ini_set("date.timezone", "America/Mexico_City");
if (sizeOf($argv)<=1){
	echo "Usage:".PHP_EOL;
	echo "\t".ME." {Coin_Pair1[,Coin_Paid2,...]}".PHP_EOL;
	echo "\t".ME." ITNS_BTC,XUN_BTC,BCN_BTC".PHP_EOL;
	exit;
}
require_once("classes/curl_get_contents/curl_get_contents.php");

$coins = explode(",", $argv[1]);
$tmpFile = tempnam("/tmp", "stex");
$o = curl_get_contents('https://stocks.exchange/api2/prices');
if (trim($o)==""){
echo "empty response".PHP_EOL;
exit(1);
}
file_put_contents($tmpFile, $o);
require_once("classes/php-jsondb/JSONDB.Class.php");
require_once("classes/format_this/format_this.php");
$json_db = new JSONDB();
foreach($coins as $k=>$coinpair){
echo "$coinpair:".PHP_EOL;
// exit;
$price = $json_db -> select( 'buy, sell, market_name, updated_time'  )
                  -> from( $tmpFile )
                  -> where(['market_name' => $coinpair])
                  -> get();
                  
$price[0]['buy'] = formatThis($price[0]['buy']);
$price[0]['sell'] = formatThis($price[0]['sell']);
$price[0]['updated_time'] = date("Ymd H:i:s", $price[0]['updated_time']);

foreach ($price[0] as $k=>$v){
  echo "\t$k: $v".PHP_EOL;
}
}

