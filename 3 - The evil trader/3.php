<?php

$stock = array();
while(!feof(STDIN)){
	$stock[] = str_replace(array("\r", "\n") , "", fgets(STDIN));
}


$count = count($stock);
$max = array(0,0,0);

/*
//"bruteforce" mode
foreach($stock as $mid => $val){
	for($i = $mid + 1; $i < $count; ++$i){
		$gan = $stock[$i] - $val;
		if($gan > 0 and $max[0] < $gan){
			$max = array($gan, $mid, $i);
		}
	}
}
*/

$tmp = $stock;
arsort($tmp);
$high = array();
foreach($tmp as $k => $v){
	$high[] = array($k, $v);
}
foreach($stock as $mid => $val){
	foreach($high as $arr){
		if($arr[0] > $mid){
			$gan = $arr[1] - $val;
			if($gan > 0 and $max[0] < $gan){
				$max = array($gan, $mid, $arr[0]);
			}
			break;
		}
	}
}

echo $max[1] * 100," ", $max[2] * 100, " ", $max[0],PHP_EOL;

?>