<?php

function bigint2bit($result, $bigendian = false){
	//Big number division
	$bit = "";
	
	//because php doesn't handle bigendian and big integers, I've got to create
	//my own functions to work with big numbers.
	//The conversion is done the way I learnt in school (it just works!)
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


//here starts

$count = intval(fgets(STDIN));
for($t = 0; $t < $count; ++$t){ //same here like the last challenge
	$int = str_replace(array("\r", "\n") , "", fgets(STDIN));
	$num1 = "1";
	$tmp = "1";
	$p = 0;
	while(bccomp($int, $tmp) == 1){ //$tmp < $int
		$num1 = $tmp; //$num1 will be The Chosen One
		$tmp = bcsub(bcpow("2",$p), "1");
		++$p;
	}
	$num2 = bcsub($int, $num1); //we get the other num
	echo "Case #",$t + 1,": ",strlen(str_replace("0", "", bigint2bit($num1).bigint2bit($num2))),PHP_EOL; //we could use substr_count to count 1's, but I discovered it in the middle of the contest
}