<?php



function encryptIt($string) {global $cryptKey;
$output=urlencode((mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $string, MCRYPT_MODE_CBC, md5(md5($cryptKey)))));
$output = str_replace("+", "%2B",$output);
$output = str_replace(".", "|",$output);
return $output;
}

function decryptIt($string) {global $cryptKey;
$string = str_replace("|", ".",$string);
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