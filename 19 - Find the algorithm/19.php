<?php


//my custom function
function bigint2bit($result, $bigendian = true){
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
	return $bigendian == false ? strrev($bit):$bit;
}
//also custom
function hexToBin($str){
	$ret = "";
	foreach(str_split($str, 2) as $hex){
		$ret .= str_pad(decbin(hexdec($hex)), 8, "0", STR_PAD_LEFT);
	}
	return $ret;
}

//yes, own function
function binToHex($str){
	$ret = "";
	foreach(str_split($str, 8) as $hex){
		$ret .= str_pad(dechex(bindec($hex)), 2, "0", STR_PAD_LEFT);
	}
	return $ret;
}

//I'm boring of doing this... Also own function
function bigendian_int($str){
	$bits = array_map("intval",str_split($str,1));
	$v = 0;
	$x = 0;
	for($i = strlen($str) - 1; $i >= 0; --$i){
		$v += pow(2, $i) * $bits[$x];
		++$x;
	}
	return $v;

}


//The SUPER-HARD challenge: base64
$out = hexToBin(base64_decode(fgets(STDIN)));
$len = strlen($out);



$res = "";
$int = 0;
foreach(str_split($out,32) as $chr){ //split by 32 bits
	$cur = bigendian_int($chr);
	if(($cur - $int) > 15 or ($cur - $int) < -16){ //if it's out of the limits of an 5-bit number
		$res .= "1".$chr; //new "bignumber"
	}else{		
		if(($cur - $int) < 0){
			$tmp = str_pad(decbin(abs($cur - $int) - 1), 5, "0", STR_PAD_LEFT); //if negative, calculate correct values
			for($i = 0; $i < 5; ++$i){
				$tmp{$i} = $tmp{$i} == "0" ? "1":"0";
			}
		}else{
			$tmp = str_pad(decbin(abs($cur - $int)), 5, "0", STR_PAD_LEFT); //positive
		}
		
		$res .= "0".$tmp;
	}
	$int = $cur;
}

$len = strlen($res);
if(($len % 8) > 0){ //pad with 0's
$res .= str_repeat("0",8 - ( $len % 8));

}

//encode and replace "="
echo str_replace("=", "", base64_encode(binToHex($res))),PHP_EOL;