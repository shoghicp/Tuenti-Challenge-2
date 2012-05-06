<?php


function gcf($a, $b) { 
	return $b == "0" ? $a: gcf($b, bcmod($a, $b) ); 
}
function lcm($a, $b) { 
	return bcmul(bcdiv($a,gcf($a,$b)), $b); 
}
function lcm_nums($ar) {
	if (count($ar) > 1) {
		$ar[] = lcm( array_shift($ar) , array_shift($ar) );
		return lcm_nums( $ar );
	} else {
		return $ar[0];
	}
}

$lines = array();

while(!feof(STDIN)){
	$lines[] = explode(" ", strtoupper(trim(str_replace(array("\r", "\n") , "", fgets(STDIN)))));
}

array_shift($lines);


ini_set("memory_limit", "2048M");


foreach($lines as $n => $line){
	$N = intval($line[0]);
	$L = intval($line[1]);

	$startStack = array();
	for($i = 1; $i <= $N; ++$i){
		$startStack[] = $i;
	}
	$stack = $startStack;

	$count = 1;
	$changes = array();

		$st1 = array();
		for($i = 0; $i < $L; ++$i){
			$st1[] = array_shift($stack);
		}
		$st2 = $stack;
		$stack = array();
		$cnt = min(count($st1), count($st2));	
		for($i = 0; $i < $cnt; ++$i){
			$ct = count($st1) - 1;
			$ct2 = count($st2) - 1;		
			$stack[] = array_pop($st1);
			$stack[] = array_pop($st2);		
		}
		$cnt = count($st1);
		if($cnt > 0){
			for($i = 0; $i < $cnt; ++$i){
				$stack[] = array_pop($st1);
			}
		}
		$cnt = count($st2);
		if($cnt > 0){
			for($i = 0; $i < $cnt; ++$i){
				$stack[] = array_pop($st2);
			}
		}
		for($i = 1; $i <= $N; ++$i){
			$changes[$i - 1] = array_search($i, $stack);
		}
		$repeat = array();
		for($i = 1; $i <= $N; ++$i){
			$firstPos = $i - 1;
			$pos = $firstPos;
			$t = 0;
			while(true){
				++$t;
				$pos = $changes[$pos];
				if($pos === $firstPos){
					break;
				}
			}
			$repeat[$i - 1] = $t;
		}
		
	echo "Case #",$n + 1,": ",lcm_nums($repeat),PHP_EOL;
}
