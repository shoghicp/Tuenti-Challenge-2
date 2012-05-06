<?php

function get_longest_common_subsequence($string_1, $string_2)
{
        $string_1_length = strlen($string_1);
        $string_2_length = strlen($string_2);
        $return          = array();
 
        if ($string_1_length === 0 || $string_2_length === 0)
        {
                // No similarities
                return $return;
        }
 
        $longest_common_subsequence = array();
 
        // Initialize the CSL array to assume there are no similarities
        for ($i = 0; $i < $string_1_length; $i++)
        {
                $longest_common_subsequence[$i] = array();
                for ($j = 0; $j < $string_2_length; $j++)
                {
                        $longest_common_subsequence[$i][$j] = 0;
                }
        }
 
        $largest_size = 0;
 
        for ($i = 0; $i < $string_1_length; $i++)
        {
                for ($j = 0; $j < $string_2_length; $j++)
                {
                        // Check every combination of characters
                        if ($string_1[$i] === $string_2[$j])
                        {
                                // These are the same in both strings
                                if ($i === 0 || $j === 0)
                                {
                                        // It's the first character, so it's clearly only 1 character long
                                        $longest_common_subsequence[$i][$j] = 1;
                                }
                                else
                                {
                                        // It's one character longer than the string from the previous character
                                        $longest_common_subsequence[$i][$j] = $longest_common_subsequence[$i - 1][$j - 1] + 1;
                                }
 
                                if ($longest_common_subsequence[$i][$j] > $largest_size)
                                {
                                        // Remember this as the largest
                                        $largest_size = $longest_common_subsequence[$i][$j];
                                        // Wipe any previous results
                                        $return       = array();
                                        // And then fall through to remember this new value
                                }
 
                                if ($longest_common_subsequence[$i][$j] === $largest_size)
                                {
                                        // Remember the largest string(s)
                                        $return[] = substr($string_1, $i - $largest_size + 1, $largest_size);
                                }
                        }
                        // Else, $CSL should be set to 0, which it was already initialized to
                }
        }
 
        // Return the list of matches
        return $return;
}
function hexToBin($str){
	$ret = "";
	foreach(str_split($str, 2) as $hex){
		$ret .= str_pad(decbin(hexdec($hex)), 8, "0", STR_PAD_LEFT);
	}
	return $ret;
}

ini_set("memory_limit", "2048M");

$in = "YmM3OWYxMDNiYzc5ZjEwMWJjNzlmMGZjYmM3OWYwZmJiYzc5ZjBlYWJjNzlmMGY3YmM3OWYxMGFiYzc5ZjEwNWJjNzlmMTAxYmM3OWYxMTBiYzc5ZjEyMGJjNzlmMTMwYmM3OWYxM2ViYzc5ZjEzY2JjNzlmMTI5YmM3OWYxMTliYzc5ZjExMWJjNzlmMTI0YmM3OWYxMTRiYzc5ZjExY2JjNzlmMTFkYmM3OWYxMjRiYzc5ZjEyMWJjNzlmMTFlYmM3OWYxMWJiYzc5ZjExNGJjNzlmMTFhYmM3OWYxMDliYzc5ZjExM2JjNzlmMTE2YmM3OWYxMDJiYzc5ZjEwOGJjNzlmMTE1YmM3OWYxMDViYzc5ZjBmYWJjNzlmMTA5YmM3OWYxMTZiYzc5ZjEyMWJjNzlmMTMwYmM3OWYxNDJiYzc5ZjEzY2JjNzlmMTNhYmM3OWYxNDZiYzc5ZjEzMmJjNzlmMTI2YmM3OWYxMjViYzc5ZjEyMmJjNzlmMTEwYmM3OWYxMWJiYzc5ZjExNGJjNzlmMTBkYmM3OWYxMTFiYzc5ZjEwZWJjNzlmMTEwYmM3OWYwZmViYzc5ZjBlY2JjNzlmMGQ5YmM3OWYwZDRiYzc5ZjBlMWJjNzlmMGRiYmM3OWYwZTRiYzc5ZjBlYmJjNzlmMGRlYmM3OWYwZTRiYzc5ZjBlN2JjNzlmMGYyYmM3OWYwZGViYzc5ZjBjYmJjNzlmMGNkYmM3OWYwY2NiYzc5ZjBiZWJjNzlmMGM1YmM3OWYwYzViYzc5ZjBjNWJjNzlmMGI1YmM3OWYwYjhiYzc5ZjBhZmJjNzlmMGJlYmM3OWYwYmRiYzc5ZjBjNWJjNzlmMGM1YmM3OWYwZDliYzc5ZjBkMGJjNzlmMGRkYmM3OWYwZGFiYzc5ZjBkM2JjNzlmMGUxYmM3OWYwZTBiYzc5ZjBlM2JjNzlmMGUzYmM3OWYwZDJiYzc5ZjBkYmJjNzlmMGVlYmM3OWYwZGNiYzc5ZjBkYmJjNzlmMGNkYmM3OWYwZDNiYzc5ZjBlN2JjNzlmMGY4YmM3OWYwZmRiYzc5ZjBmZmJjNzlmMGY1YmM3OWYxMDNiYzc5ZjBmOWJjNzlmMGYzYmM3OWYwZjZiYzc5ZjBlNWJjNzlmMGU2YmM3OWYwZjJiYzc5ZjBlZWJjNzlmMGVlYmM3OWYwZjNiYzc5ZjBmMmJjNzlmMTAxYmM3OWYxMDdiYzc5ZjBmZmJjNzlmMGYzYmM3OWYwZjViYzc5ZjBlN2JjNzlmMGY4YmM3OWYxMGFiYzc5ZjExN2JjNzlmMTIxYmM3OWYxMzFiYzc5ZjEyYmJjNzlmMTNmYmM3OWYxNGFiYzc5ZjE0ZWJjNzlmMTVjYmM3OWYxNTZiYzc5ZjE0NWJjNzlmMTRiYmM3OWYxNDRiYzc5ZjE1OGJjNzlmMTQ2YmM3OWYxNGViYzc5ZjE0MmJjNzlmMTNkYmM3OWYxMzBiYzc5ZjEyMWJjNzlmMTFkYmM3OWYxMTNiYzc5ZjEwNGJjNzlmMTAzYmM3OWYxMTJiYzc5ZjEwOWJjNzlmMTBmYmM3OWYwZmNiYzc5ZjBlZmJjNzlmMGYwYmM3OWYwZjJiYzc5ZjBlZmJjNzlmMGVjYmM3OWYwZWRiYzc5ZjBlMGJjNzlmMGUzYmM3OWYwZjViYzc5ZjBmZWJjNzlmMGZlYmM3OWYxMGRiYzc5ZjBmZWJjNzlmMGYxYmM3OWYwZjZiYzc5ZjBmNmJjNzlmMTAxYmM3OWYxMDBiYzc5ZjBmM2JjNzlmMGY0YmM3OWYxMDJiYzc5ZjBmN2JjNzlmMTA4YmM3OWYxMDhiYzc5ZjExMWJjNzlmMGZmYmM3OWYwZmFiYzc5ZjBlZGJjNzlmMGYwYmM3OWYxMDRiYzc5ZjBmY2JjNzlmMTBkYmM3OWYwZmJiYzc5ZjEwNWJjNzlmMGY2YmM3OWYwZjRiYzc5ZjEwMWJjNzlmMTAyYmM3OWYxMDdiYzc5ZjExOWJjNzlmMTJkYmM3OWYxMWRiYzc5ZjExM2JjNzlmMTBkYmM3OWYxMGZiYzc5ZjBmZGJjNzlmMGVmYmM3OWYwZTFiYzc5ZjBkYWJjNzlmMGNiYmM3OWYwY2NiYzc5ZjBkNGJjNzlmMGM0YmM3OWYwYjdiYzc5ZjBiNWJjNzlmMGM4YmM3OWYwYzNiYzc5ZjBkNGJjNzlmMGMxYmM3OWYwYjJiYzc5ZjBiMWJjNzlmMGE1YmM3OWYwYjBiYzc5ZjBhNWJjNzlmMGFmYmM3OWYwOWRiYzc5ZjBhNGJjNzlmMDkyYmM3OWYwOWViYzc5ZjBhM2JjNzlmMDhmYmM3OWYwODZiYzc5ZjA3YWJjNzlmMDgzYmM3OWYwOTZiYzc5ZjBhNmJjNzlmMGExYmM3OWYwYTJiYzc5ZjA5NWJjNzlmMDllYmM3OWYwOGZiYzc5ZjA4ZmJjNzlmMDhkYmM3OWYwODliYzc5ZjA3Y2JjNzlmMDc1";
$out = "ZGUzY2Y4ODFiY2RiZmJjNzlmMGVhMzc3OGYzZTIxNGRiODdlZjFlN2M0ODM3OGYzZTI2MDczZGJjNzlmMTI5NDE4ZGUzY2Y4OTIyMDQwMjNiYWViYWM4ZGJjNzlmMTA5MjgzZGUzY2Y4ODEwYzZhMGE5ZTY5NjdlZjFlN2M1MDlhNzhjZGUzY2Y4OTkyOGZiYmJjNzlmMTEwMmQ5NjQ0NzQyZGUzY2Y4N2Y2ZjFlN2MzYjM3OGYzZTFiMmQ5YWQxMjNhNjMwNjVlZjFlN2MzN2I3OGYzZTE5NjEzZTkwZTAwMDgwNmI5ZWY5MDA2ZjFlN2MzNjU3MzVkNjRlN2MzMDM3OGYzZTFhNDRlZjFlN2MzYmI3OGYzZTFiOGZhNDM2ZjFlN2MzOWY3OGYzZTFmMDI4NGIxY2IzNDFlZjFlN2MzOTQxMzFjMDA1N2NmMTk4NTAyNGI3OGYzZTFmMWJjNzlmMTBhMzRhZGUzY2Y4OThiNWJjNzlmMTNmMmM0MzlhZGUzY2Y4YTI4Y2NlZjFlN2M1NjM3OGYzZTI4YzQyOGRhNjhiOGIyMmY5ZWI4ZGJjNzlmMGZjNGMxMDlkNzQxNGMzZGUzY2Y4N2E5MjAxZThhNjI4MDViZTk4MjcyYmJjNzlmMTA4MDA5ZGUzY2Y4N2ZiNjk4N2JjNzlmMTA0NjM3OGYzZTIxYmJjNzlmMGZiMjkxNzhkMDQ1ZGUzY2Y4OGNlZjFlN2M0YjUwNTlhMGI3OGYzZTFmYTkyNGNhMjA5MDgyNmY2ZjFlN2MzMjFiZGUzY2Y4NmE2ZjFlN2MzMDUxN2Q0MmQ1MmI3OGYzZTEzYTNlZjFlN2MyNDhjMTc3OGYzZTExZWJhODRlZjFlN2MyNWI3OGYzZTE0Y2Q4Mjk5Mjg4MGYzODliMg";
$in = base64_decode($in);
$out = base64_decode($out);

$text = get_longest_common_subsequence(hexToBin($in),hexToBin($out));
print_R($text);