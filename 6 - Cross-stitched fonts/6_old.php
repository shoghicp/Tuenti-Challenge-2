<?php
//Que mierda es esto!!!
//En serio, no entiendo alguna parte, pero esto se adapta


function getStiches($chars, $size){
	return $chars * (pow($size, 2)/2);
}

function canMake($text, $width, $height, $ct, $size){
	$tlen = strlen(str_replace(" ", "", $text));
	$words = explode(" ",$text);
	$curlen = 0;
	$curline = 0;
	$columns = floor(($width * $ct)/$size);
	$lines = floor(($height * $ct)/$size);
	
	//echo $size,"|",($columns * $lines - ($lines > 1 ? 1:0)),"|",($tlen + count($words)),PHP_EOL;
	return ($tlen + count($words)) < ($columns * $lines - ($height > 1 ? 1:0));
	
	/*if(($columns * $lines) < $tlen){
		return false;
	}
	foreach($words as $word){
		$len = strlen($word);
		if($len > $columns){
			return false;
		}
		if(($curlen + $len + 1) > $columns){
			if(($curline + 1) > $lines){
				return false;
			}
			++$curline;
			$curlen = $len;
		}else{
			$curlen += 1 + $len;
		}
	}
	return true;*/
}

function getMaxSize($text, $width, $height, $ct){
	//$letters = count(explode(" ", $text));
	$s = 0;
	while(true){
		//echo ceil(getStiches(strlen(str_replace(" ", "", $text)), $s + 1) * (1/$ct)),"|";
		if(!canMake($text, $width, $height, $ct, $s + 1)){
			break;
		}
		++$s;
	}
	return $s;
}

$count = str_replace(array("\r", "\n") , "", fgets(STDIN));

for($c = 1; $c <= $count; ++$c){
	$line = explode(" ", str_replace(array("\r", "\n") , "", fgets(STDIN)));
	$width = $line[0];
	$height = $line[1];
	$ct = $line[2];
	$text = str_replace(array("\r", "\n") , "", fgets(STDIN));

	$size = getMaxSize($text, $width, $height, $ct);
	//$ret = canMake($text, $width, $height, $ct, 2);
	$ret = ceil(getStiches(strlen(str_replace(" ", "", $text)), $size) * (1/$ct));
	
	echo "Case #",$c,": ", $ret,PHP_EOL;

}