<?php
    /* utility function to pad out an array of strings
        so that they are all the same length.
        Adds zeros to the begining.
    */
    function pad(&$array) {
        $max = 0;

        foreach($array as $word)
            if(($len = strlen($word)) > $max) $max = $len;

        foreach($array as $key => $word)
            $array[$key] = str_pad($word, $max, "0", STR_PAD_LEFT);

        return $max;
    }

if(!function_exists('str_split')){

    function str_split($str, $nr) {

         //Return an array with 1 less item then the one we have
         return array_slice(split("-l-", chunk_split($str, $nr, '-l-')), 0, -1);

    }
}

for($i = 0; $i < 256; $i++){ //populate dictionary with ascii characters
    $startDictionary[$i] = chr($i);
	
	}


function encodeLZW($string) {
    global $startDictionary;

    $dictionary = $startDictionary;

    $word = "";
    for($i = 0; $i < strlen($string); $i++) {
        
        $x = substr($string, $i, 1);
        if(in_array("$word$x", $dictionary, true)) {

            $word = "$word$x";


        }else{
            $encodedString[] = decbin(array_search("$word", $dictionary, true)); //encode to binary string


            $dictionary[] = "$word$x";

            $word = $x;

        }



    }


    $encodedString[]= decbin(array_search($word, $dictionary, true));  //encode to binary string

    return $encodedString;

}

function decodeLZW($string, $bits) {
    global $startDictionary;

    $dictionary = $startDictionary;

    $tokens = str_split($string, $bits); //tokenize the string - split every at every $bits, where $bits is the size of the bits used to encode one symbol.

    $decodedString = $dictionary[bindec($tokens[0])];       //function bindec - decode binary string to a decimal

    $word = $dictionary[bindec($tokens[0])];

    for($i = 1; $i < count($tokens); $i++) {

        $x = bindec($tokens[$i]);
        $element = $dictionary[$x];

        if(!isset($element)) {

            $element = $word . $word{0};

        }

        $decodedString .= $element;

        $dictionary[] = "$word{$element{0}}";
        $word = $element;

    }

    return $decodedString;
}

function hexToStr($str){
	$ret = "";
	foreach(str_split($str, 2) as $hex){
		$ret .= chr(hexdec($hex));
	}
	return $ret;
}

function strToHex($str){
	$ret = "";
	foreach(str_split($str, 1) as $hex){
		$ret .= str_pad(dechex(ord($hex)), 2, "0", STR_PAD_LEFT);
	}
	return $ret;
}




    //echo stripslashes($_POST[toEncode]); //show the text being encoded
    //echo "<br /><Br />";


$in = "YmM3OWYxMDNiYzc5ZjEwMWJjNzlmMGZjYmM3OWYwZmJiYzc5ZjBlYWJjNzlmMGY3YmM3OWYxMGFiYzc5ZjEwNWJjNzlmMTAxYmM3OWYxMTBiYzc5ZjEyMGJjNzlmMTMwYmM3OWYxM2ViYzc5ZjEzY2JjNzlmMTI5YmM3OWYxMTliYzc5ZjExMWJjNzlmMTI0YmM3OWYxMTRiYzc5ZjExY2JjNzlmMTFkYmM3OWYxMjRiYzc5ZjEyMWJjNzlmMTFlYmM3OWYxMWJiYzc5ZjExNGJjNzlmMTFhYmM3OWYxMDliYzc5ZjExM2JjNzlmMTE2YmM3OWYxMDJiYzc5ZjEwOGJjNzlmMTE1YmM3OWYxMDViYzc5ZjBmYWJjNzlmMTA5YmM3OWYxMTZiYzc5ZjEyMWJjNzlmMTMwYmM3OWYxNDJiYzc5ZjEzY2JjNzlmMTNhYmM3OWYxNDZiYzc5ZjEzMmJjNzlmMTI2YmM3OWYxMjViYzc5ZjEyMmJjNzlmMTEwYmM3OWYxMWJiYzc5ZjExNGJjNzlmMTBkYmM3OWYxMTFiYzc5ZjEwZWJjNzlmMTEwYmM3OWYwZmViYzc5ZjBlY2JjNzlmMGQ5YmM3OWYwZDRiYzc5ZjBlMWJjNzlmMGRiYmM3OWYwZTRiYzc5ZjBlYmJjNzlmMGRlYmM3OWYwZTRiYzc5ZjBlN2JjNzlmMGYyYmM3OWYwZGViYzc5ZjBjYmJjNzlmMGNkYmM3OWYwY2NiYzc5ZjBiZWJjNzlmMGM1YmM3OWYwYzViYzc5ZjBjNWJjNzlmMGI1YmM3OWYwYjhiYzc5ZjBhZmJjNzlmMGJlYmM3OWYwYmRiYzc5ZjBjNWJjNzlmMGM1YmM3OWYwZDliYzc5ZjBkMGJjNzlmMGRkYmM3OWYwZGFiYzc5ZjBkM2JjNzlmMGUxYmM3OWYwZTBiYzc5ZjBlM2JjNzlmMGUzYmM3OWYwZDJiYzc5ZjBkYmJjNzlmMGVlYmM3OWYwZGNiYzc5ZjBkYmJjNzlmMGNkYmM3OWYwZDNiYzc5ZjBlN2JjNzlmMGY4YmM3OWYwZmRiYzc5ZjBmZmJjNzlmMGY1YmM3OWYxMDNiYzc5ZjBmOWJjNzlmMGYzYmM3OWYwZjZiYzc5ZjBlNWJjNzlmMGU2YmM3OWYwZjJiYzc5ZjBlZWJjNzlmMGVlYmM3OWYwZjNiYzc5ZjBmMmJjNzlmMTAxYmM3OWYxMDdiYzc5ZjBmZmJjNzlmMGYzYmM3OWYwZjViYzc5ZjBlN2JjNzlmMGY4YmM3OWYxMGFiYzc5ZjExN2JjNzlmMTIxYmM3OWYxMzFiYzc5ZjEyYmJjNzlmMTNmYmM3OWYxNGFiYzc5ZjE0ZWJjNzlmMTVjYmM3OWYxNTZiYzc5ZjE0NWJjNzlmMTRiYmM3OWYxNDRiYzc5ZjE1OGJjNzlmMTQ2YmM3OWYxNGViYzc5ZjE0MmJjNzlmMTNkYmM3OWYxMzBiYzc5ZjEyMWJjNzlmMTFkYmM3OWYxMTNiYzc5ZjEwNGJjNzlmMTAzYmM3OWYxMTJiYzc5ZjEwOWJjNzlmMTBmYmM3OWYwZmNiYzc5ZjBlZmJjNzlmMGYwYmM3OWYwZjJiYzc5ZjBlZmJjNzlmMGVjYmM3OWYwZWRiYzc5ZjBlMGJjNzlmMGUzYmM3OWYwZjViYzc5ZjBmZWJjNzlmMGZlYmM3OWYxMGRiYzc5ZjBmZWJjNzlmMGYxYmM3OWYwZjZiYzc5ZjBmNmJjNzlmMTAxYmM3OWYxMDBiYzc5ZjBmM2JjNzlmMGY0YmM3OWYxMDJiYzc5ZjBmN2JjNzlmMTA4YmM3OWYxMDhiYzc5ZjExMWJjNzlmMGZmYmM3OWYwZmFiYzc5ZjBlZGJjNzlmMGYwYmM3OWYxMDRiYzc5ZjBmY2JjNzlmMTBkYmM3OWYwZmJiYzc5ZjEwNWJjNzlmMGY2YmM3OWYwZjRiYzc5ZjEwMWJjNzlmMTAyYmM3OWYxMDdiYzc5ZjExOWJjNzlmMTJkYmM3OWYxMWRiYzc5ZjExM2JjNzlmMTBkYmM3OWYxMGZiYzc5ZjBmZGJjNzlmMGVmYmM3OWYwZTFiYzc5ZjBkYWJjNzlmMGNiYmM3OWYwY2NiYzc5ZjBkNGJjNzlmMGM0YmM3OWYwYjdiYzc5ZjBiNWJjNzlmMGM4YmM3OWYwYzNiYzc5ZjBkNGJjNzlmMGMxYmM3OWYwYjJiYzc5ZjBiMWJjNzlmMGE1YmM3OWYwYjBiYzc5ZjBhNWJjNzlmMGFmYmM3OWYwOWRiYzc5ZjBhNGJjNzlmMDkyYmM3OWYwOWViYzc5ZjBhM2JjNzlmMDhmYmM3OWYwODZiYzc5ZjA3YWJjNzlmMDgzYmM3OWYwOTZiYzc5ZjBhNmJjNzlmMGExYmM3OWYwYTJiYzc5ZjA5NWJjNzlmMDllYmM3OWYwOGZiYzc5ZjA4ZmJjNzlmMDhkYmM3OWYwODliYzc5ZjA3Y2JjNzlmMDc1";
$out = "ZGUzY2Y4ODFiY2RiZmJjNzlmMGVhMzc3OGYzZTIxNGRiODdlZjFlN2M0ODM3OGYzZTI2MDczZGJjNzlmMTI5NDE4ZGUzY2Y4OTIyMDQwMjNiYWViYWM4ZGJjNzlmMTA5MjgzZGUzY2Y4ODEwYzZhMGE5ZTY5NjdlZjFlN2M1MDlhNzhjZGUzY2Y4OTkyOGZiYmJjNzlmMTEwMmQ5NjQ0NzQyZGUzY2Y4N2Y2ZjFlN2MzYjM3OGYzZTFiMmQ5YWQxMjNhNjMwNjVlZjFlN2MzN2I3OGYzZTE5NjEzZTkwZTAwMDgwNmI5ZWY5MDA2ZjFlN2MzNjU3MzVkNjRlN2MzMDM3OGYzZTFhNDRlZjFlN2MzYmI3OGYzZTFiOGZhNDM2ZjFlN2MzOWY3OGYzZTFmMDI4NGIxY2IzNDFlZjFlN2MzOTQxMzFjMDA1N2NmMTk4NTAyNGI3OGYzZTFmMWJjNzlmMTBhMzRhZGUzY2Y4OThiNWJjNzlmMTNmMmM0MzlhZGUzY2Y4YTI4Y2NlZjFlN2M1NjM3OGYzZTI4YzQyOGRhNjhiOGIyMmY5ZWI4ZGJjNzlmMGZjNGMxMDlkNzQxNGMzZGUzY2Y4N2E5MjAxZThhNjI4MDViZTk4MjcyYmJjNzlmMTA4MDA5ZGUzY2Y4N2ZiNjk4N2JjNzlmMTA0NjM3OGYzZTIxYmJjNzlmMGZiMjkxNzhkMDQ1ZGUzY2Y4OGNlZjFlN2M0YjUwNTlhMGI3OGYzZTFmYTkyNGNhMjA5MDgyNmY2ZjFlN2MzMjFiZGUzY2Y4NmE2ZjFlN2MzMDUxN2Q0MmQ1MmI3OGYzZTEzYTNlZjFlN2MyNDhjMTc3OGYzZTExZWJhODRlZjFlN2MyNWI3OGYzZTE0Y2Q4Mjk5Mjg4MGYzODliMg";
$input = base64_decode($in);

    $output = implode(encodeLZW($input));        //do the encoding

var_dump($output);



?>