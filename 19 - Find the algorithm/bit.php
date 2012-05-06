<?php

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

echo bigendian_int($argv[1]),PHP_EOL;