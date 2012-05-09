<?php


function line($p1, $p2){
	// Ax + By + C = 0
	$A = $p2[1] - $p1[1];
	$B = -($p2[0] - $p1[0]);
	$C = ($p1[1] * $p2[0]) - ($p1[0] * $p2[1]);
	return array("A" => $A, "B" => $B, "C" => $C);
}

function lineDistance($vertex, $line){
	return (($line["A"] * $vertex[0]) + ($line["B"] * $vertex[1]) + $line["C"]) / sqrt(pow($line["A"], 2) +  pow($line["B"], 2));
}


function getDistance($cord1, $cord2){
	return sqrt( pow($cord1[0] - $cord2[0], 2) + pow($cord1[1] - $cord2[1], 2));
}

function getDifference($cord1, $cord2){
	$res1 = $cord1[0] - $cord2[0];
	$res2 = $cord1[1] - $cord2[1];
	return array(abs($res1),abs($res2));
}


$lines = array();
while(!feof(STDIN)){
	$lines[] = trim(str_replace(array("\r", "\n") , "", fgets(STDIN)));
}

bcscale(20);

$cases = intval(trim(array_shift($lines)));
for($c = 1; $c <= $cases; ++$c){
	$t = explode(" ", trim(array_shift($lines)));
	$result = false;
	$continue = true;
	//Voy a colocar la pizza siempre en el centro, porque si no se me cae de la mesa para cortar
	$center = array(floatval($t[0]), floatval($t[1]));
	$radius = $t[2];
	$ingredientCount = intval(trim(array_shift($lines)));
	$ingredients = array();
	if($ingredientCount <= 1){
		$continue = false;
		$result = true;
	}
		for($i = 0; $i < $ingredientCount; ++$i){
			$t = explode(" ", trim(array_shift($lines)));
			$id = $t[0];
			$ingredients[$id] = array();
			$ingredients[$id]["edges"] = intval($t[1]);
			$ingredients[$id]["count"] = intval($t[2]);
			if(($ingredients[$id]["count"] % 2) == 1){ //Impares no pueden dividirse
				$continue = false;
			}
			$ingredients[$id]["place"] = array();
			for($x = 0; $x < $ingredients[$id]["count"]; ++$x){
				$t = explode(" ", trim(array_shift($lines)));
				$ingredients[$id]["place"][$x] = array();
				$ingredients[$id]["place"][$x]["center"] = array(floatval($t[0]) - $center[0], floatval($t[1]) - $center[1]);
				$ingredients[$id]["place"][$x]["vertex"] = array();
				$vert = array(floatval($t[2]) - $center[0], floatval($t[3]) - $center[1]);
				$rad = getDistance($ingredients[$id]["place"][$x]["center"], $vert);
				$diff = getDifference($ingredients[$id]["place"][$x]["center"], $vert);
				// $a = $diff[0];
				// $b = $diff[1];
				// $c = $rad;
				$alfa = (2 * pi()) / $ingredients[$id]["edges"];
				$angle = asin($diff[0]/$rad);
				for($beta = 0; $beta < (2 * pi()); $beta += $alfa){
					$ingredients[$id]["place"][$x]["vertex"][] = array(sin($beta + $angle) * $rad + $ingredients[$id]["place"][$x]["center"][0], cos($beta + $angle) + $rad, $ingredients[$id]["place"][$x]["center"][1]);
				}
			}
		}
	if($continue == true){
		//Warning! The big loop-in-a-loop-in-a-loop-in-a-loop-in-a-loop-in-a-loop-in-a-loop is coming!
		$aaa = 0;
		foreach($ingredients as $i => $data){
			if($continue === false){
				break;
			}
			foreach($data["place"] as $coord){
				if($continue === false){
					break;
				}
				
				foreach($coord["vertex"] as $t){
					$Icount = array();
					$line = line($t, $center);
					$continue2 = true;
					foreach($ingredients as $x => $arr){
						if($continue === false or $continue2 === false){
							break;
						}
						foreach($arr["place"] as $v => $p){
							if($continue === false or $continue2 === false){
								break;
							}
							unset($positive);
							/*if($p["vertex"][0][0] == $t[0] and $p["vertex"][0][1] == $t[1] ){
								//echo "HI";
								break;
							}*/
							foreach($p["vertex"] as $z){
								$d = lineDistance($z, $line);
								if($d == 0){
									
								}elseif($d < 0){
									if(!isset($positive)){
										$positive = false;
									}elseif($positive == true){
										$continue2 = false;
										break;
									}
								}else{
									if(!isset($positive)){
										$positive = true;
									}elseif($positive == false){
										$continue2 = false;
										break;
									}
								}
							}
							if(!isset($Icount[$x])){
								$Icount[$x] = 0;
							}
							if($positive == true){
								++$Icount[$x];
							}else{
								--$Icount[$x];
							}
						}						
					}
					
					if($continue === false){
						break;
					}elseif($continue2 === false){
						continue;
					}
					$ret = false;
					foreach($Icount as $n){
						if($n != 0){
							$ret = true;
							break;
						}
					}
					if($ret == false){
						$continue = false;
						$result = true;
					}
				}
			}
		}
	}

	//print_r($ingredients);

	echo "Case #",$c,": ",($result == true ? "TRUE":"FALSE"),PHP_EOL;

}