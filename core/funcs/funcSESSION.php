<?php





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