<?php

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

function getPoints($word){
	$len = strlen($word);
	$points = 0;
	$values = array(
		"A" => 1,
		"E" => 1,
		"I" => 1,
		"L" => 1,
		"N" => 1,
		"O" => 1,
		"R" => 1,
		"S" => 1,
		"T" => 1,
		"U" => 1,
		
		"D" => 2,
		"G" => 2,
		
		"B" => 3,
		"C" => 3,
		"M" => 3,
		"P" => 3,
		
		"F" => 4,
		"H" => 4,
		"V" => 4,
		"W" => 4,
		"Y" => 4,
		
		"K" => 5,
		
		"J" => 8,
		"X" => 8,
		
		"Q" => 10,
		"Z" => 10,
	);
	
	for($i = 0; $i < $len; ++$i){
		$points += $values[$word{$i}];
	}
	return $points;
}

function precalculate(){
	$wordlist = explode("\n", file_get_contents(dirname(__FILE__)."/descrambler_wordlist.txt"));
	$words = array();
	foreach($wordlist as $word){
		$word = trim($word);
		$w = str_split($word, 1);
		natcasesort($w);
		$w = implode($w);
		$p = getPoints($w);
		if(!isset($words[$w])){
			$words[$w] = array($word, $p);
		}elseif($words[$w][1] < $p or ($words[$w][1] == $p and strcmp($words[$w][0], $word) > 0)){
			$words[$w] = array($word, $p);
		}
	}
	return $words;

}

$words = precalculate();

$lines = array();

while(!feof(STDIN)){
	$lines[] = explode(" ", strtoupper(trim(str_replace(array("\r", "\n") , "", fgets(STDIN)))));
}

array_shift($lines);

foreach($lines as $line){
	$len = strlen($line[1]);
	$wlen = strlen($line[0]);
	$max = array("", 0);	
	for($y = 0; $y <= $len; ++$y){
		for($x = 0; $x < $wlen; ++$x){
			for($i = 0; $i < $len; ++$i){
				$v = str_split(substr($line[0], $x) . $line[1]{$i}, 1);			
				natcasesort($v);
				$v = implode($v);
				
				if(!isset($words[$v])){
					continue;
				}elseif($words[$v][1] > $max[1] or ($words[$v][1] == $max[1] and strcmp($words[$v][0], $max[0]) < 0)){
					$max = $words[$v];
				}
			}
		}
		$line[0] = str_split($line[0], 1);
		$line[0][] = array_shift($line[0]);
		$line[0] = implode($line[0]);
	}
	echo $max[0]," ", $max[1],PHP_EOL;
}