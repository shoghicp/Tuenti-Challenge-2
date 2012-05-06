<?php

$i1 = "01111001";
$i2 = "10110111";


$len = strlen($i1);

$res = "";
for($i = 0; $i < $len; ++$i){
	$res .= (intval($i1{$i}) ^ intval($i2{$i})) == 0 ? "0":"1";

}

echo $res;