<?php


function golombEncode($source, $M)
 {
$dest = "";
        $num = bigendian_int($source);
        $q = $num / $M;
         for ($i = 0 ; $i < $q; $i++){
             $dest .= "1";   // write q ones
		}
       $dest .= "0";    // write one zero
         $v = 1;
         for ($i = 0 ; $i < log($M,2); $i++)
         {            
            $dest .= decbin( $v & $num );  
             $v = $v << 1;         
         }
	return $dest;
 }

function levenstein($int){
	if($int == 0){
		return "0";
	}
	$ret = "";
	$C = 1;
	$b = substr(decbin($int), 1);
	$ret .= $b;
	$M = strlen($b);

}

function eliasGammaEncode($source)
{
$dest = "";
        $num = bigendian_int($source);
        $l = log($num, 2);
        for ($a=0; $a < $l; $a++){
            $dest .= "0"; //put 0s to indicate how many bits will follow
        }
		$dest .= "1";     //mark the end of the 0s
        for ($a=$l-1; $a >= 0; $a--) //Write the bits as plain binary
        {
            if ($num & 1 << $a){
                $dest .= "1";
            }else{
                $dest .= "0";
			}
        }
	return $dest;
}

function encode_fib($n){
    # Return string with Fibonacci encoding for n (n >= 1).
    $result = "";
    if ($n >= 1){
        $a = 1;
        $b = 1;
        $c = $a + $b;   # next Fibonacci number
        $fibs = array($b);  # list of Fibonacci numbers, starting with F(2), each <= n
        while ($n >= $c){
            $fibs[] = $c;  # add next Fibonacci number to end of list
            $a = $b;
            $b = $c;
            $c = $a + $b;
		}
        $result = "1";  # extra "1" at end
        foreach(array_reverse($fibs) as $fibnum){
            if($n >= $fibnum){
                $n = $n - $fibnum;
                $result = "1" . $result;
            }else{
                $result = "0" . $result;
			}
		}
	}
    return $result;
}

function hexToBin($str){
	$ret = "";
	foreach(str_split($str, 2) as $hex){
		$ret .= str_pad(decbin(hexdec($hex)), 8, "0", STR_PAD_LEFT);
	}
	return $ret;
}

function bigendian_int($str){
	$bits = array_map("intval",str_split($str,1));
	$v = 0;
	$x = 0;
	for($i = strlen($str) - 1; $i >= 0; --$i){
		$v += pow(2, $i) * $bits[$x];
		++$x;
	}
	return $v;

}

$in = "YmM3OWYxMDNiYzc5ZjEwMWJjNzlmMGZjYmM3OWYwZmJiYzc5ZjBlYWJjNzlmMGY3YmM3OWYxMGFiYzc5ZjEwNWJjNzlmMTAxYmM3OWYxMTBiYzc5ZjEyMGJjNzlmMTMwYmM3OWYxM2ViYzc5ZjEzY2JjNzlmMTI5YmM3OWYxMTliYzc5ZjExMWJjNzlmMTI0YmM3OWYxMTRiYzc5ZjExY2JjNzlmMTFkYmM3OWYxMjRiYzc5ZjEyMWJjNzlmMTFlYmM3OWYxMWJiYzc5ZjExNGJjNzlmMTFhYmM3OWYxMDliYzc5ZjExM2JjNzlmMTE2YmM3OWYxMDJiYzc5ZjEwOGJjNzlmMTE1YmM3OWYxMDViYzc5ZjBmYWJjNzlmMTA5YmM3OWYxMTZiYzc5ZjEyMWJjNzlmMTMwYmM3OWYxNDJiYzc5ZjEzY2JjNzlmMTNhYmM3OWYxNDZiYzc5ZjEzMmJjNzlmMTI2YmM3OWYxMjViYzc5ZjEyMmJjNzlmMTEwYmM3OWYxMWJiYzc5ZjExNGJjNzlmMTBkYmM3OWYxMTFiYzc5ZjEwZWJjNzlmMTEwYmM3OWYwZmViYzc5ZjBlY2JjNzlmMGQ5YmM3OWYwZDRiYzc5ZjBlMWJjNzlmMGRiYmM3OWYwZTRiYzc5ZjBlYmJjNzlmMGRlYmM3OWYwZTRiYzc5ZjBlN2JjNzlmMGYyYmM3OWYwZGViYzc5ZjBjYmJjNzlmMGNkYmM3OWYwY2NiYzc5ZjBiZWJjNzlmMGM1YmM3OWYwYzViYzc5ZjBjNWJjNzlmMGI1YmM3OWYwYjhiYzc5ZjBhZmJjNzlmMGJlYmM3OWYwYmRiYzc5ZjBjNWJjNzlmMGM1YmM3OWYwZDliYzc5ZjBkMGJjNzlmMGRkYmM3OWYwZGFiYzc5ZjBkM2JjNzlmMGUxYmM3OWYwZTBiYzc5ZjBlM2JjNzlmMGUzYmM3OWYwZDJiYzc5ZjBkYmJjNzlmMGVlYmM3OWYwZGNiYzc5ZjBkYmJjNzlmMGNkYmM3OWYwZDNiYzc5ZjBlN2JjNzlmMGY4YmM3OWYwZmRiYzc5ZjBmZmJjNzlmMGY1YmM3OWYxMDNiYzc5ZjBmOWJjNzlmMGYzYmM3OWYwZjZiYzc5ZjBlNWJjNzlmMGU2YmM3OWYwZjJiYzc5ZjBlZWJjNzlmMGVlYmM3OWYwZjNiYzc5ZjBmMmJjNzlmMTAxYmM3OWYxMDdiYzc5ZjBmZmJjNzlmMGYzYmM3OWYwZjViYzc5ZjBlN2JjNzlmMGY4YmM3OWYxMGFiYzc5ZjExN2JjNzlmMTIxYmM3OWYxMzFiYzc5ZjEyYmJjNzlmMTNmYmM3OWYxNGFiYzc5ZjE0ZWJjNzlmMTVjYmM3OWYxNTZiYzc5ZjE0NWJjNzlmMTRiYmM3OWYxNDRiYzc5ZjE1OGJjNzlmMTQ2YmM3OWYxNGViYzc5ZjE0MmJjNzlmMTNkYmM3OWYxMzBiYzc5ZjEyMWJjNzlmMTFkYmM3OWYxMTNiYzc5ZjEwNGJjNzlmMTAzYmM3OWYxMTJiYzc5ZjEwOWJjNzlmMTBmYmM3OWYwZmNiYzc5ZjBlZmJjNzlmMGYwYmM3OWYwZjJiYzc5ZjBlZmJjNzlmMGVjYmM3OWYwZWRiYzc5ZjBlMGJjNzlmMGUzYmM3OWYwZjViYzc5ZjBmZWJjNzlmMGZlYmM3OWYxMGRiYzc5ZjBmZWJjNzlmMGYxYmM3OWYwZjZiYzc5ZjBmNmJjNzlmMTAxYmM3OWYxMDBiYzc5ZjBmM2JjNzlmMGY0YmM3OWYxMDJiYzc5ZjBmN2JjNzlmMTA4YmM3OWYxMDhiYzc5ZjExMWJjNzlmMGZmYmM3OWYwZmFiYzc5ZjBlZGJjNzlmMGYwYmM3OWYxMDRiYzc5ZjBmY2JjNzlmMTBkYmM3OWYwZmJiYzc5ZjEwNWJjNzlmMGY2YmM3OWYwZjRiYzc5ZjEwMWJjNzlmMTAyYmM3OWYxMDdiYzc5ZjExOWJjNzlmMTJkYmM3OWYxMWRiYzc5ZjExM2JjNzlmMTBkYmM3OWYxMGZiYzc5ZjBmZGJjNzlmMGVmYmM3OWYwZTFiYzc5ZjBkYWJjNzlmMGNiYmM3OWYwY2NiYzc5ZjBkNGJjNzlmMGM0YmM3OWYwYjdiYzc5ZjBiNWJjNzlmMGM4YmM3OWYwYzNiYzc5ZjBkNGJjNzlmMGMxYmM3OWYwYjJiYzc5ZjBiMWJjNzlmMGE1YmM3OWYwYjBiYzc5ZjBhNWJjNzlmMGFmYmM3OWYwOWRiYzc5ZjBhNGJjNzlmMDkyYmM3OWYwOWViYzc5ZjBhM2JjNzlmMDhmYmM3OWYwODZiYzc5ZjA3YWJjNzlmMDgzYmM3OWYwOTZiYzc5ZjBhNmJjNzlmMGExYmM3OWYwYTJiYzc5ZjA5NWJjNzlmMDllYmM3OWYwOGZiYzc5ZjA4ZmJjNzlmMDhkYmM3OWYwODliYzc5ZjA3Y2JjNzlmMDc1";


$in = hexToBin(base64_decode($in));


$check = array();
$last = array();
foreach(str_split($in,32) as $word){

	for($i = 0; $i < 32; ++$i){
		if(!isset($last[$i])){
			$check[$i] = true;
			$last[$i] = $word{$i};
		}elseif($check[$i] == true){
			if($last[$i] != $word{$i}){
				$check[$i] = false;
			}
		}
	}
}

$rep = "";
foreach($check as $i => $c){
	if($c == true){
		$rep .= $last[$i];
	}else{
		break;
	}
}


$out = "";
foreach(str_split($in,8) as $int){
	//$int = bigendian_int($int);
	$out .= golombEncode($int, pow(2,2));
}

echo $out,PHP_EOL;