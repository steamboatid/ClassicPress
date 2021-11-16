<?php

$emoji = "😈";

$str = str_replace('"', "", json_encode($emoji, JSON_HEX_APOS));

$myInput = $str;

$myHexString = str_replace('\\u', '', $myInput);
$myBinString = hex2bin($myHexString);

print iconv("UTF-16BE", "UTF-8", $myBinString);
$astr = iconv("UTF-16BE", "UTF-8", $myBinString);
print_r(array($emoji, $str, $myHexString, $myBinString, $astr));

print_r(iconv("UTF-16BE", "UTF-8", hex2bin("d83dde08")));
print_r("foo&#x1f608;bar");


function code_to_symbol( $emoji ) {
	if($emoji > 0x10000) {
		$first = (($emoji - 0x10000) >> 10) + 0xD800;
		$second = (($emoji - 0x10000) % 0x400) + 0xDC00;
		return json_decode('"' . sprintf("\\u%X\\u%X", $first, $second) . '"');
	} else {
		return json_decode('"' . sprintf("\\u%X", $emoji) . '"');
	}
}

$aaa=code_to_symbol(0x1F63C);
$aaa=code_to_symbol(0x1f608);
echo "\n\n $aaa \n\n";
