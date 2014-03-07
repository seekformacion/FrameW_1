<?php


function getDatSKUID($skpUID){global $idSES;
$datos=json_decode(decryptIt($skpUID), TRUE);	

if(is_array($datos)){
if(array_key_exists('idSES', $datos)){
$chkSES=$datos['idSES'];
if($chkSES==$idSES){
	
	$cents="";
	foreach ($datos['idcs'] as $key => $idc) {
	$cents.=$idc . ",";	
	}	
	$cents=substr($cents,0,-1); $firstC=$datos['idcs'][0];

if (isset($_COOKIE["selC"])){$datos['cent_sel']=$_COOKIE["selC"];}else{$datos['cent_sel']=$firstC;};
$datos['lcents']=$cents;


return $datos;	
}

}}


	
return FALSE;	 
}



function ascii2hex($ascii) {
$hex = '';
for ($i = 0; $i < strlen($ascii); $i++) {
$byte = strtoupper(dechex(ord($ascii{$i})));
$byte = str_repeat('0', 2 - strlen($byte)).$byte;
$hex.=$byte." ";
}
return $hex;
}

function hex2ascii($hex){
$ascii='';
$hex=str_replace(" ", "", $hex);
for($i=0; $i<strlen($hex); $i=$i+2) {
$ascii.=chr(hexdec(substr($hex, $i, 2)));
}
return($ascii);
}


function encryptIt($string) {global $cryptKey;
$output=ascii2hex((mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $string, MCRYPT_MODE_CBC, md5(md5($cryptKey)))));
//$output = str_replace("+", "%2B",$output);
//$output = str_replace(".", "|",$output);
return $output;
}

function decryptIt($string) {global $cryptKey;
$string = hex2ascii($string);
$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $string, MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
return $output;
}



function getUniqueCode($length){
$code = md5(uniqid(rand(), true));
return $code;
}


function create_new_user(){


$seekforID=strtoupper(getUniqueCode(10));
$res=DBUpIns("INSERT INTO skv_user_sessions (seekforID) values ('$seekforID');");

return $seekforID;# . "_" . geo_ip(getRealIpAddr());

}



?>