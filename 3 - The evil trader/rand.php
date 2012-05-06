<?php

for($i = 0; $i < 5000; ++$i){
	file_put_contents(dirname(__FILE__)."/test", mt_rand(60, 300).PHP_EOL, FILE_APPEND);
}