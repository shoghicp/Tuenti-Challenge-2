<?php

//Input is the number of straight cuts made through a round chocolate cake and output is the maximum number of cake pieces that can be produced.

$lines = array();
while(!feof(STDIN)){
	$lines[] = trim(str_replace(array("\r", "\n") , "", fgets(STDIN)));
}

array_shift($lines);
$c = 1;
foreach($lines as $line){
	if($line == ""){
		continue;
	}
	$x = intval($line);
	echo "Case #",$c,": ",(0.5*pow($x,2) + 0.5*$x + 1),PHP_EOL;
	++$c;
}