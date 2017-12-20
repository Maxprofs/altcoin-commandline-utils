<?php

function formatThis($size, $precision = 3)
{
$s1 = ($size / 1E-8);
if ($s1 >0 && $s1<1000){
  return "$s1 [sat]";
}else{
  return "$size";
}
}
