#!/usr/bin/php
<?php
define("ME", $argv[0]);
function profit($coin, $format="txt"){
  require_once("classes/curl_get_contents/curl_get_contents.php");
  switch(strtoupper($coin)){
    case "ITNS":
      $stats = "http://192.124.18.154:8117/live_stats";
      $rewdiv = 1E8;
      break;
    case "XUN":
      // a pool stats json
      $stats = "http://alpha.ultranote.org:8117/stats";
      $rewdiv = 1E6;
      break;
    case "BCN":
      // a json api block explorer
      $stats = "https://chainradar.com/api/v1/bcn/status";
      $rewdiv = 1E8;
      break;
    case "XMR":
      // a json api block explorer
      $stats = "http://moneroblocks.info/api/get_stats/";
      $rewdiv = 1E12;
      break;
    case "DERO":
      $stats = "http://pool.dero.live:8117/live_stats";
      $rewdiv = 1E12;
      break;
    default:
      echo "coin not found";
      exit(1);
      break;
  }
  $o = curl_get_contents($stats);
  $d = json_decode($o);
  $hashRate = 1024;
  switch(strtoupper($coin)){
    case "ITNS":
    case "XUN":
    case "DERO":
      $diff = $d->network->difficulty;
      $reward = $d->network->reward;
      $symbol = $d->config->symbol;
      break;
    case "BCN":
      $diff = $d->difficulty;
      $reward = $d->reward;
      $symbol = $coin;
      break;      
    case "XMR":
      $diff = $d->difficulty;
      $reward = $d->last_reward;
      $symbol = $coin;
      break;
    default:
      echo "coin not found";
      exit(1);
      break;
  }

  $profit = ($reward*$hashRate * 86400) / ($diff*$rewdiv);



  switch($format){
  case "txt":
    $o = "profit: $profit [$symbol / day] at 1KH/s".PHP_EOL;
    break;
  case "number":
  case "num":
    $o = $profit;
    break;
  default:
    echo "def:";
    exit(1);
    break;
  }
  return $o;
}

if (sizeOf($argv)<=1){
	echo "Usage:".PHP_EOL;
	echo "supported coins: ITNS,XMR,BCN,XUN,DERO".PHP_EOL;
	echo "example (notice no spaces between coin names)".PHP_EOL;
	echo "\t".ME." ITNS,XMR,BCN".PHP_EOL;
	echo "\t".ME." ITNS".PHP_EOL;
	exit;
}

$coins = explode(",", $argv[1]);
foreach ($coins as $k => $coin){
  echo profit($coin);
}

