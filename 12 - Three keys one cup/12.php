<?php

$input = strtolower(trim(str_replace(array("\r", "\n") , "", fgets(STDIN))));

$keys = array(
	0 => md5("wisdom"), //From 0x66 to 0x85
	1 => md5("courage"), //Got from QRcode
	2 => md5("power"),
);

$res = "00000000000000000000000000000000";

for($i = 0; $i < 32; ++$i){
	foreach($keys as $k){
		$res{$i} = dechex((hexdec($res{$i}) + hexdec($k{$i})) % 16);
	}
	$res{$i} = dechex((hexdec($res{$i}) + hexdec($input{$i})) % 16);
}

echo $res;

?>