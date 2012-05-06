<?php

/*
function non_recursive_replace($search, $replace, $str){
	$findings = array();
	$replaces = array();
	foreach($search as $i => $find){
		$replaces[$find] = array($replace[$i], strlen($find));
		preg_match_all("/$find/", $str, $matches, PREG_OFFSET_CAPTURE);
		foreach($matches[0] as $pos){
			$findings[$pos[1]] = $pos[0];
		}
	}
	ksort($findings);
	$offset = 0;
	$result = "";
	foreach($findings as $off => $find){
		$cnt = $off - $offset;
		if($cnt > 0){
			$result .= substr($str, $offset, $cnt);
		}
		$result .= $replaces[$find][0];
		$offset += $cnt + $replaces[$find][1];
	}
	$result .= substr($str, $offset);
	return $result;
}*/


function non_recursive_replace($search, $replace, $str){
	$len = strlen($str);
	$result = "";
	$res = array();
	for($l = 0; $l < $len; ++$l){
		$char = $str{$l};
		if(!isset($res[$char])){
			$tmp = "";
			foreach(preg_grep("/$char/", $search) as $i => $find){
				$tmp .= $replace[$i];
			}
			$res[$char] = $tmp;
		}
		
		if($res[$char] === ""){
			$result .= $char;
		}else{
			$result .= $res[$char];
		}
	}
	unset($str);
	return $result;
}

function special_non_recursive_replace($search, $replace, $str, $len = -1){
	if(!isset($str{$len-1})){
		$len = strlen($str);
	}
	$result = "";
	for($l = 0; $l < $len; ++$l){
		$char = $str{$l};
		if(!isset($search[$char])){
			$result .= $char;
		}else{
			$result .= $search[$char];
		}
	}
	return $result;
}


$lines = array();
while(!feof(STDIN)){
	$lines[] = str_replace(array("\r", "\n") , "", fgets(STDIN));
}

ini_set("memory_limit", "2048M");

$outfile = dirname(__FILE__)."/out.tmp";

$queue = trim(array_shift($lines));
file_put_contents($outfile."0", $queue);

$lcnt = count($lines);
$search = array();
$special = array();
$replace = array();

for($l = 0; $l < $lcnt; ++$l){
	unset($transformations);
	$transformations = array();
	$tmp = array_map("trim", explode(",",$lines[$l]));
	foreach($tmp as $tf){
		$tf = explode("=>", $tf);
		if(!isset($transformations[trim($tf[0])])){
			$transformations[trim($tf[0])] = "";
		}
		$transformations[trim($tf[0])] .= trim($tf[1]);
	}
	$search[$l] = array();
	$replace[$l] = array();
	$i = 0;
	foreach($transformations as $chr => $add){
		$search[$l][$i] = $chr;
		if(!isset($special[$l][$chr])){
			$special[$l][$chr] = "";
		}
		$special[$l][$chr] .= $add;
		$replace[$l][$i] = $add;
		++$i;
	}
}

$fr = fopen($outfile."0", "r");

$len = 1024 * 1024 * 16;
for($l = 0; $l < $lcnt; ++$l){
	$fw = fopen($outfile."".($l + 1)."", "w+");	
	while(!feof($fr)){
		@fwrite($fw, special_non_recursive_replace($special[$l], $replace[$l], @fread($fr, $len), $len));
	}
	fclose($fr);
	@unlink($outfile."$l");
	$fr = $fw;
	rewind($fr);
}

fclose($fr);
echo md5_file($outfile."$l"),PHP_EOL;
@unlink($outfile."$l");
?>