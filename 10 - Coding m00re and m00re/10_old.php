<?php

$lines = array();
while(!feof(STDIN)){
	$lines[] = explode(" ", trim(str_replace(array("\r", "\n") , "", fgets(STDIN))));
}

$instructions = array(
	"mirror" => 'return -$token[0];',
	"breadandfish" => 'return $token[0] * ($token[2] == "#" ? $token[0]:$token[2]);',


);

foreach($lines as $tokens){
	$numbers = array();
	foreach($tokens as $tok){
		$c = count($numbers) - 1;
		switch($tok){
			case "dance":
				$tmp = $numbers[$c];
				$numbers[$c] = $numbers[$c - 1];
				$numbers[$c - 1] = $tmp;
				break;
			case "mirror":
				$numbers[$c] = bcmul(array_pop($numbers), "-1");
				break;
			case "conquer":
				$numbers[$c - 1] = $numbers[$c - 1] % array_pop($numbers);
				break;
			case "breadandfish":
				$numbers[$c + 1] = $numbers[$c];
				break;
			case "fire":
				array_pop($numbers);
				break;
			case '$':
				$numbers[$c - 1] = bcsub($numbers[$c - 1], array_pop($numbers));
				break;
			case '@':
				$numbers[$c - 1] = bcadd($numbers[$c - 1], array_pop($numbers));
				break;
			case '#':
				$numbers[$c - 1] = bcmul($numbers[$c - 1], array_pop($numbers));
				break;
			case '&':
				$numbers[$c - 1] = bcdiv($numbers[$c - 1], array_pop($numbers));
				break;
			case '.':
				echo $numbers[$c],PHP_EOL;
				break;
			default:
				$numbers[] = $tok;
				break;
		}
	}
}