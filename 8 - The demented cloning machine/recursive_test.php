<?php

function non_recursive_replace($search, $replace, $str){
	$str = str_split($str, 1);
	$result = "";
	foreach($str as $char){
		if(in_array($char, $search)){
			foreach($search as $i => $find){
				if($char === $find){
					$result .= $replace[$i];
				}
			}
		}else{
			$result .= $char;
		}		
	}
	unset($str);
	return $result;

}