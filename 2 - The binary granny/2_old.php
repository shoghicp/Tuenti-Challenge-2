<?php

function bigint2bit($result, $bigendian = false){
	//Big number division
	$bit = "";
	while($result != "0" and $result != "1"){
		$int = str_split($result, 1);
		$len = count($int);
		$tmp = "";
		$tmp2 = "";
		$result = "";
		for($i = 0; $i < $len; ++$i){
			$int[$i] = intval($tmp2 . $int[$i]);
			$result .= (string) floor($int[$i]/2);
			$tmp2 = (string) $int[$i] % 2;
		}
		$bit .= $tmp2;
		$result = (string) intval($result);
	}
	$bit .= $result;
	return $bigendian == true ? strrev($bit):$bit;
}

function bit_substract($int, $sub){
	//Only > 0 and $int > $sub
	$int = array_map("intval", str_split($int, 1));
	$len = count($int);
	$sub = array_map("intval", str_split(str_pad($sub, $len, "0", STR_PAD_LEFT), 1));
	
	$res = "";
	$carry = 0;
	for($i = 0; $i < $len; ++$i){
		$res .= abs($int[$i] ^ $sub[$i] ^ $carry) == 1 ? "1":"0";
		$carry = $int[$i] < ($sub[$i] + $carry) ? 1:0;
	}
	return $res;
}

/*echo bigint2bit("2135"),PHP_EOL;

$int = str_replace(array("\r", "\n") , "", "2135");//fgets(STDIN));

$bits = bigint2bit($int);

$num1 = "";
$num2 = "";

$len = strlen($bits);

$max = 0;

for($i = 0; $i < $len; ++$i){
	$num1 .= "1";
	$num2 .= $bits{$i} == "1" ? "0":"1";
}



echo bit_substract($bits, "1"),PHP_EOL;*/

$count = intval(fgets(STDIN));
for($t = 0; $t < $count; ++$t){
	$int = str_replace(array("\r", "\n") , "", fgets(STDIN));
	$num1 = "1";
	$tmp = "1";
	$p = 0;
	while(bccomp($int, $tmp) == 1){
		$num1 = $tmp;
		$tmp = bcsub(bcpow("2",$p), "1");
		++$p;
	}
	$num2 = bcsub($int, $num1);
	echo "Case #",$t + 1,": ",strlen(str_replace("0", "", bigint2bit($num1).bigint2bit($num2))),PHP_EOL;
}