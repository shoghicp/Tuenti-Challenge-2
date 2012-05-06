<?php

$lines = array();
while(!feof(STDIN)){
	$lines[] = str_replace(array("\r", "\n") , "", fgets(STDIN));
}


$path = dirname(__FILE__)."/documents/";

$cases = intval(trim(array_shift($lines)));
$search = array();
$offsets = array();
//$offset = 0;

foreach($lines as $line){
	$line = explode(" ",str_replace("  ", " ", $line));
	$l = trim(array_shift($line));
	$search[] = array($l, intval(trim(implode($line))), strlen($l));
	$offsets[] = 0;
}
$findings = array();

for($d = 1; $d <= 800; ++$d){
	if(count($search) == 0){
		break;
	}
	$str = file_get_contents($path . str_pad($d, 4, "0", STR_PAD_LEFT));
	//$len = strlen($str);
	foreach($search as $i => $find){
		unset($matches);
		/*$cnt = substr_count($str, $find[0]);
		if(){
		
		}*/
		preg_match_all('/\b'.$find[0].'\b/i', $str, $matches, PREG_OFFSET_CAPTURE);
		foreach($matches[0] as $match){
			++$offsets[$i];
			if($offsets[$i] == $find[1]){
				$tmp = explode("\n", substr($str, 0, $match[1] + $find[2]));
				$findings[$i] = array($d, count($tmp), count(explode(" ", trim(array_pop($tmp)))));
				unset($search[$i]);
				unset($offsets[$i]);
				break;
			}
		}
	}
	//$offset += $len;
}

ksort($findings);

foreach($findings as $array){
	echo implode("-", $array),PHP_EOL;
}