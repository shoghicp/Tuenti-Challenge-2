<?php


// lights on for a given number
$leds = array(
	"-" => array(0,0,0,0,0,0,0), // starting position
	"0" => array(1,1,1,0,1,1,1),
	"1" => array(0,0,1,0,0,1,0),
	"2" => array(1,0,1,1,1,0,1),
	"3" => array(1,0,1,1,0,1,1),
	"4" => array(0,1,1,1,0,1,0),
	"5" => array(1,1,0,1,0,1,1),
	"6" => array(1,1,0,1,1,1,1),
	"7" => array(1,0,1,0,0,1,0),
	"8" => array(1,1,1,1,1,1,1),
	"9" => array(1,1,1,1,0,1,1),
);


//sum on leds for a given number
function getLeds($num){
	global $leds;
	return array_sum($leds[$num]);
}

//get leds difference
function getLedsDiff($num1, $num2){
	global $leds;
	$ledC = 0;
	foreach($leds[$num1] as $i => $a){
		if($leds[$num2][$i] == 1 and $a == 0){
			++$ledC;
		}
	}
	return $ledC;
}


//we calculate changes in a day
$secondsDay = 60 * 60 * 24;
$onPerDayIn = calculateLeds(0, $secondsDay);
$onPerDayEf = calculateLeds(0, $secondsDay, true);


//function to calculate led powering from a start time to ending
function calculateLeds($start, $end, $efficient = false){
	$on = 0;

	$diff = $end - $start;
	$clock = array("--", "--", "--");
	for($i = 0; $i <= $diff; ++$i){
		$toS = str_pad($i % 60, 2, "0", STR_PAD_LEFT);
		$toM = str_pad(floor($i / 60) % 60, 2, "0", STR_PAD_LEFT);
		$toH = str_pad(floor($i / 60 / 60) % 24, 2, "0", STR_PAD_LEFT);
		if($efficient == false){
			$on += getLeds($toH{0});
			$on += getLeds($toH{1});
			$on += getLeds($toM{0});
			$on += getLeds($toM{1});
			$on += getLeds($toS{0});
			$on += getLeds($toS{1});
		}else{
			$on += getLedsDiff($clock[0]{0}, $toH{0});
			$on += getLedsDiff($clock[0]{1}, $toH{1});
			$on += getLedsDiff($clock[1]{0}, $toM{0});
			$on += getLedsDiff($clock[1]{1}, $toM{1});
			$on += getLedsDiff($clock[2]{0}, $toS{0});
			$on += getLedsDiff($clock[2]{1}, $toS{1});
		}
		$clock = array($toH, $toM, $toS);
	}
	return $on;
}

//get seconds from time
function getSecs($str){
	$str = explode(":", $str);
	$secs = 0;
	$secs += intval($str[0]) * 3600;
	$secs += intval($str[1]) * 60;
	$secs += intval($str[2]);
	return $secs;
}

while(!feof(STDIN)){
	$line = str_replace(array("\r", "\n") , "", fgets(STDIN));
	$time = explode(" - ", $line);
	if(!isset($time[1])){ //blank lines doesn't stop me ;) (learnt form last challenge)
		continue;
	}

	$start = explode(" ", $time[0]);
	$startDays = strtotime($start[0]);
	$startSec = strtotime($start[1]);
	
	$end = explode(" ", $time[1]);
	$endDays = strtotime($end[0]);
	$endSec = strtotime($end[1]);
	$sec = $endSec - $startSec;
	//$endSec = getSecs($end[1]);
	
	$days = ($endDays - $startDays) / $secondsDay; //calculate days 
	$onIn = bcmul($onPerDayIn, "$days"); //sum changes per day
	$onIn = bcadd($onIn, calculateLeds(0, $sec)); //and add the restant changes
	$onEf = bcmul($onPerDayEf, "$days"); //same here
	$onEf = bcadd($onEf, calculateLeds(0, $sec, true));
	echo bcsub($onIn, $onEf),PHP_EOL; //difference
}