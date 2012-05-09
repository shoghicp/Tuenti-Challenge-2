<?php
	$words = array("Ook", "Bee");
	
	$program = str_replace(array("\r","\n"," ","\t"), "",file_get_contents($argv[1]));
	
	$oplen = 1; //brainf***
	foreach($words as $w){
		if(strpos($program, $w) !== false){
			$oplen = 2;
			break;
		}
	}
	$program = str_split(str_replace($words, "", $program), $oplen);
	$memory = array();	
	
	$Mp = 0;
	$Pp = 0;
	$ops = count($program);
	
	while(true){
		$op = $program[$Pp];
		if(!isset($memory[$Mp])){
			$memory[$Mp] = 0;
		}
		//echo "Mp: 0x".str_pad(dechex($Mp), 8, "0", STR_PAD_LEFT)." (".dechex($memory[$Mp]).") - Pp: 0x".str_pad(dechex($Pp), 8, "0", STR_PAD_LEFT). " (".$op.")",PHP_EOL;

		switch($op){
			case ".?":
			case ">":
				++$Mp;
				break;
			case "?.":
			case "<":
				--$Mp;
				break;
			case "..":
			case "+":
				++$memory[$Mp];
				break;
			case "!!":
			case "-":
				--$memory[$Mp];
				break;
			case ".!":
			case ",":
				$memory[$Mp] = ord(fread(STDIN, 1));
				break;
			case "!.":
			case ".":
				echo chr($memory[$Mp]);
				break;
			case "!?":
			case "[":
				if($memory[$Mp] == 0){
					$par = 0;
					for($x = $Pp + 1; $x < $ops; ++$x){
						if($program[$x] == "!?" or $program[$x] == "["){
							++$par;
						}elseif($program[$x] == "?!" or $program[$x] == "]"){
							if($par == 0){
								$Pp = $x;
								break;
							}else{
								--$par;
							}
						}
					}
				}
				break;
			case "?!":
			case "]":
				if($memory[$Mp] != 0){
					$par = 0;
					for($x = $Pp - 1; $x >= 0; --$x){
						if($program[$x] == "?!" or $program[$x] == "]"){
							++$par;
						}elseif($program[$x] == "!?" or $program[$x] == "["){
							if($par == 0){
								$Pp = $x;
								break;
							}else{
								--$par;
							}
						}
					}
				}
				break;
		
		}
		
		++$Pp;
		if($Pp >= $ops){
			die();
		}
	}
	
?>