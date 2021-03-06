<?php

/*
here it is the keypad

I could have optimized it, but I were in hurry to complete it

*/
$lines = array( 
3 => array(" 1", "ABC2", "DEF3"),
2 => array("GHI4", "JKL5", "MNO6"),
1 => array("PQRS7", "TUV8", "WXYZ9"),
0 => array("", "0", "-"),
);

//here we search the position of a given letter (this function exists because non-optimization)
function getPos($letter){
	global $lines;
	$letter = strtoupper($letter);
	$coords = false;
	foreach($lines as $y => $keys){
		if($coords !== false){ //this could be at the end of the loop
			break;
		}
		foreach($keys as $x => $pad){
			$pos = strpos($pad, $letter);
			if($pos !== false){
				$coords = array($x, $y, $pos);
				break;
			}
		}
	}
	return $coords;
}

//here we calculate the time to move from a key to another
function moveTime($from, $to){
	$time = 0;
	$diffTX = $from[0] - $to[0];
	$diffTY = $from[1] - $to[1];
	$diffX = abs($diffTX);
	$diffY = abs($diffTY);
	while($diffX > 0 or $diffY > 0){
		//a loop... I didn't thought a better way to do it,
		//but now I have some ideas (I learnt form the contest itself)
		if($diffTX != 0 and $diffTY != 0 and $diffX > 0 and $diffY > 0){
			//Diagonal
			--$diffX;
			--$diffY;
			if($diffTX > 0){
				--$diffTX;
			}else{
				++$diffTX;
			}
			if($diffTY > 0){
				--$diffTY;
			}else{
				++$diffTY;
			}
			$time += 350;

		}
		if($diffX < $diffY){
			//Vertical
			--$diffY;
			if($diffTY > 0){
				--$diffTY;
			}else{
				++$diffTY;
			}
			$time += 300;

		}
		if($diffX > $diffY){
			//Horizontal
			--$diffX;
			if($diffTX > 0){
				--$diffTX;
			}else{
				++$diffTX;
			}
			$time += 200;

		}
	}
	return $time;
}

//calculate time, takes into account caps
function calculateTime($target){
	global $pointer, $upper;
	$time = 0;
	if($upper == true and strtoupper($target) != $target){
		//Lowercase
		$pos = array(2, 0, 0); //Fast exec (-)
		$time += moveTime($pointer, $pos);
		$time += 100;
		$upper = false;

		$pointer = $pos;
	}elseif($upper == false and strtolower($target) != $target){
		//Uppercase
		$pos = array(2, 0, 0); //Fast exec (-)
		$time += moveTime($pointer, $pos);
		$time += 100;
		$upper = true;

		$pointer = $pos;
	}
	$pos = getPos($target);
	if($pos[0] == $pointer[0] and $pos[1] == $pointer[1]){
		//Same key
		$time += 500;

	}else{
		$time += moveTime($pointer, $pos);
	}
	$time += 100 + 100 * $pos[2];

	$pointer = $pos;
	return $time;
}

//here we go!

$count = intval(fgets(STDIN));

for($t = 0; $t < $count; ++$t){ //loops around cases
	$time = 0;
	$upper = false;
	$pointer = array(1, 0, 0);//Fast exec (0)
	$str = str_replace(array("\r", "\n") , "", fgets(STDIN)); //a line. we have to strip newlines and breaks

	$len = strlen($str); //ALWAYS calculate time before a loop

	for($i = 0; $i < $len; ++$i){
		$time += calculateTime($str{$i});
	}

	echo $time,PHP_EOL;

}

?>