<?php

$lines = array( 
3 => array(" 1", "ABC2", "DEF3"),
2 => array("GHI4", "JKL5", "MNO6"),
1 => array("PQRS7", "TUV8", "WXYZ9"),
0 => array("", "0", "-"),
);
/*

|
|
Y
|
|
----X----

*/


function getPos($letter){
	global $lines;
	$letter = strtoupper($letter);
	$coords = false;
	foreach($lines as $y => $keys){
		if($coords !== false){
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

function moveTime($from, $to){
	$time = 0;
	$diffTX = $from[0] - $to[0];
	$diffTY = $from[1] - $to[1];
	$diffX = abs($diffTX);
	$diffY = abs($diffTY);
	while($diffX > 0 or $diffY > 0){
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
			//echo 350,PHP_EOL;
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
			//echo 300,PHP_EOL;
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
			//echo 200,PHP_EOL;
		}
	}
	return $time;
}

function calculateTime($target){
	global $pointer, $upper;
	$time = 0;
	if($upper == true and strtoupper($target) != $target){
		//Lowercase
		$pos = array(2, 0, 0); //Fast exec (-)
		$time += moveTime($pointer, $pos);
		$time += 100;
		$upper = false;
		//echo 100,PHP_EOL;
		$pointer = $pos;
	}elseif($upper == false and strtolower($target) != $target){
		//Uppercase
		$pos = array(2, 0, 0); //Fast exec (-)
		$time += moveTime($pointer, $pos);
		$time += 100;
		$upper = true;
		//echo 100,PHP_EOL;
		$pointer = $pos;
	}
	$pos = getPos($target);
	if($pos[0] == $pointer[0] and $pos[1] == $pointer[1]){
		//Same key
		$time += 500;
		//echo 500,PHP_EOL;
	}else{
		$time += moveTime($pointer, $pos);
	}
	$time += 100 + 100 * $pos[2];
	/*for($i = 0; $i <= $pos[2]; ++$i){
		echo 100,PHP_EOL;
	}*/
	$pointer = $pos;
	return $time;
}



$count = intval(fgets(STDIN));

for($t = 0; $t < $count; ++$t){
	$time = 0;
	$upper = false;
	$pointer = array(1, 0, 0);//Fast exec (0)
	$str = str_replace(array("\r", "\n") , "", fgets(STDIN));
	//file_put_contents(dirname(__FILE__)."/in", $str.PHP_EOL, FILE_APPEND);
	$len = strlen($str);

	for($i = 0; $i < $len; ++$i){
		$time += calculateTime($str{$i});
	}

	echo $time,PHP_EOL;

}

?>