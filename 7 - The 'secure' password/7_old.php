<?php

$chars = array();
while(!feof(STDIN)){
	$chars[] = str_replace(array("\r", "\n") , "", fgets(STDIN));
}

//----- STOLEN FROM STACKOVERFLOW -----
// function to generate and print all N! permutations of $str. (N = strlen($str)).
function string_getpermutations($prefix, $characters, &$permutations)
{
    if (count($characters) == 1)
        $permutations[] = $prefix . array_pop($characters);
    else
    {
        for ($i = 0; $i < count($characters); $i++)
        {
            $tmp = $characters;
            unset($tmp[$i]);

            string_getpermutations($prefix . $characters[$i], array_values($tmp), $permutations);
        }
    }
}
//----- END -----

function str_push($str, $str2, $pos){
	$len = strlen($str);
	$pos = intval($pos);
	return substr($str,0, -$len + $pos).$str2.substr($str,$pos);
}

function factorial($num){
	$num = intval($num);
	$ret = 1;
	for($i = 2; $i <= $num; ++$i){
		$ret *= $i;
	}
	return $ret;
}


$before = array();
$after = array();

foreach($chars as $c){
	$len = strlen($c);
	$chr = array();
	for($i = 0; $i < $len; ++$i){
		foreach($chr as $v){
			if(!isset($before[$c{$i}])){
				$before[$c{$i}] = array();
			}
			if(!in_array($v, $before[$c{$i}])){
				$before[$c{$i}][] = $v;
			}
		}
		$chr[] = $c{$i};
	}
	for($i = 0; $i < $len; ++$i){
		for($y = $i + 1; $y < $len; ++$y){
			if(!isset($after[$c{$i}])){
				$after[$c{$i}] = array();
			}
			if(!in_array($c{$y}, $after[$c{$i}])){
				$after[$c{$i}][] = $c{$y};
			}
		}
	}
}

foreach($before as $char => $b){
	foreach($b as $c){
		if(isset($before[$c])){
			foreach($before[$c] as $v){
				if(!in_array($v, $before[$char])){
					$before[$char][] = $v;
				}
			}
		}else{
			$before[$c] = array();
		}
	}
}

foreach($after as $char => $b){
	foreach($b as $c){
		if(isset($after[$c])){
			foreach($after[$c] as $v){
				if(!in_array($v, $after[$char])){
					$after[$char][] = $v;
				}
			}
		}else{
			$after[$c] = array();
		}
	}
}



$ordered = array();
$selected = "";
$count = count($before);

foreach($before as $char => $b){
	$countB = count($b);
	$countA = $count - count($after[$char]) - 1;
	if(!isset($ordered[$countB])){
		$ordered[$countB] = array();
	}
	if(!in_array($char, $ordered[$countB])){
		$ordered[$countB][] = $char;
	}
	if(!isset($ordered[$countA])){
		$ordered[$countA] = array();
	}
	if(!in_array($char, $ordered[$countA])){
		$ordered[$countA][] = $char;
	}
}


$keys = array(0 => "");
$start = $count;
for($i = 0; $i < $count; ++$i){
	if(!isset($ordered[$i])){
		$keys[0] .= " ";
		$start = min($start, $i);
		continue;
	}elseif(count($ordered[$i]) > 1){
		$keys[0] .= " ";
		$start = min($start, $i);
		continue;
	}
	$keys[0] .= $ordered[$i][0];
}

$used = array();
foreach($ordered as $i => $n){
	$c = count($n);
	if($c > 1){		
		for($x = 0; $x < $c; ++$x){
			if(!isset($used[$n[$x]])){
				$used[$n[$x]] = $n[$x];
			}
		}
	}
}

$tot = factorial(count($used));
$used = str_split(implode($used),1);
$permutations = array();
string_getpermutations("", $used, $permutations);
$k = explode(" ", str_replace(array("  ", "   "), " ", str_replace(array("  ", "   "), " ",$keys[0])));
$z = 0;
if(floor($len/2) != ceil($len/2)){
	$n = $start + floor($len/2);
	foreach($ordered[$n - 1] as $c){
		if(!in_array($c, $ordered[$n])){
			$ordered[$n][] = $c;
		}
	}
	foreach($ordered[$n + 1] as $c){
		if(!in_array($c, $ordered[$n])){
			$ordered[$n][] = $c;
		}
	}	
}

foreach($permutations as $c){
	$len = strlen($c);
	$go = true;
	for($i = 0; $i < $len; ++$i){
		if(!in_array($c{$i}, $ordered[$start + $i])){
			$go = false;
		}
	}
	if($go == true){		
		$keys[$z] = $k[0].$c.$k[1];
		++$z;
	}
}

foreach($keys as $key){
	echo $key,PHP_EOL;
}


?>