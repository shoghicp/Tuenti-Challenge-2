<?php

//new style of getting input! we put all in an array ;)
$stock = array();
while(!feof(STDIN)){
	$stock[] = str_replace(array("\r", "\n") , "", fgets(STDIN));
}


$count = count($stock);
$max = array(0,0,0);


$tmp = $stock;
arsort($tmp); //we order stock from high to low. Search optimization
$high = array();
foreach($tmp as $k => $v){
	$high[] = array($k, $v); //we put these in an array containing the original index and value
}
foreach($stock as $mid => $val){
	foreach($high as $arr){
		if($arr[0] > $mid){ //if it happens after the current stock
			$gan = $arr[1] - $val; //ganancy
			if($gan > 0 and $max[0] < $gan){ //if higher than curr value
				$max = array($gan, $mid, $arr[0]); //replace the older max value with the new
			}
			break;
		}
	}
}

echo $max[1] * 100," ", $max[2] * 100, " ", $max[0],PHP_EOL; //convert to ms and display value

?>