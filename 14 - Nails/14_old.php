<?php

function hamming_code($str){
	$d = str_split($str, 1);
	$bits = array();
	$p = array();
	$i = 1;
	while(count($d) > 0){
		if(($i & ($i - 1)) == 0){
			$bits[$i] = 0;
			array_unshift($p, $i);
			++$i;
			continue;
		}
		$bits[$i] = array_shift($d) == "1" ? 1:0;
		++$i;
	}
	$cnt = count($bits);
	foreach($p as $x){
		for($i = $x + 1; $i <= $cnt; ++$i){
			if(($i & $x) == $x){
				$bits[$x] ^= $bits[$i];
			}
		}
	}
	return implode($bits);
	
}

function hamming_code_check($str){
	$bits = str_split($str, 1);
	$cnt = count($bits);
	array_unshift($bits, 0);
	$error = array();
	for($i = 1; $i <= $cnt; ++$i){
		if(($i & ($i - 1)) == 0){
			$v = 0;
			for($x = $i + 1; $x <= $cnt; ++$x){
				if(($x & $i) == $i){
					$v ^= $bits[$x];
				}
			}
			if($v != $bits[$i]){
				$error[$i] = $i;
			}
		}
	}

	$ecnt = count($error);
	if($ecnt > 0){
		$bits[array_sum($error)] ^= 1;
	}
	$ret = array();
	for($i = 1; $i <= $cnt; ++$i){
		if(($i & ($i - 1)) != 0){
			$ret[] = $bits[$i];
		}
	}
	return implode($ret);
}

$lines = array();

while(!feof(STDIN)){
	$lines[] = trim(str_replace(array("\r", "\n") , "", fgets(STDIN)));
	
}

foreach($lines as $line){
	if($line == ""){
		continue;
	}
	$ret = ""; 
	if(strlen($line) % 7 != 0){
		echo "Error!",PHP_EOL;
		continue;
	}
	foreach(str_split($line,7) as $l){
		$ret .= $val = hamming_code_check($l);
	}
	$bytes = strlen($ret) / 8;
	$ret2 = "";
	for($i = 0; $i < $bytes; ++$i){
		$chr = bindec(substr($ret, $i * 8, 8));
		if($chr < 32 or $chr > 126){
			echo "Error!",PHP_EOL;
			break;
		}
		$ret2 .= chr($chr);
	}
	if($chr < 32 or $chr > 126){
		break;
	}
	echo $ret2,PHP_EOL;
}