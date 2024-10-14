<?php 
function kaps_encrypt($key)
{
$s = $key;
$z = $_SERVER['HTTP_HOST'];
$n = strlen($z);
$n = $n*1785;
$z .= $n; 
$c = "AES-128-CTR"; 
$v = openssl_cipher_iv_length($c); 
$o = 0; 
$v = '1234567891011121'; 
$k = $z; 
  
$encryption = openssl_encrypt($s, $c, $k, $o, $v); 
return $encryption;
}