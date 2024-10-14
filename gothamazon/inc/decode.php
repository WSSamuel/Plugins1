<?php 
function kaps_decrypt($s)
{
$e = $s;
$z = $_SERVER['HTTP_HOST'];
$n = strlen($z);
$n = $n*1785;
$z .= $n;
$o = 0; 
$v = '1234567891011121'; 
$k = $z; 
$c = "AES-128-CTR";
$decryption=openssl_decrypt ($e, $c, $k, $o, $v); 
return $decryption; 
}