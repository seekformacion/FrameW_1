<?php


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
	
	if($ip=="127.0.0.1"){$ip="37.11.40.103";};
    return $ip;
}


function getUniqueCode($length){
		
$code = md5(uniqid(rand(), true));
if ($length != "") return substr($code, 0, $length);
    else return $code;
}


function create_new_user(){


$seekforID=strtoupper(getUniqueCode(10));
$res=DBUpIns("INSERT INTO skv_user_sessions (seekforID) values ('$seekforID');");

return $seekforID;# . "_" . geo_ip(getRealIpAddr());

}


function geo_ip($ipaddress)
{
	
#$license_key="TsbcQPRGZjU0";#e
$license_key="g9wRUqbb76W3";#b

$query = "http://geoip.maxmind.com/b?l=" . $license_key . "&i=" . $ipaddress;
$url = parse_url($query);
$host = $url["host"];
$path = $url["path"] . "?" . $url["query"];
$timeout = 1;
$fp = fsockopen ($host, 80, $errno, $errstr, $timeout)
	or die('Can not open connection to server.');
if ($fp) {
  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
  while (!feof($fp)) {
    $buf .= fgets($fp, 128);
  }
  $lines = explode("\n", $buf);
  $data = $lines[count($lines)-1];
  fclose($fp);
} else {
  # enter error handing code here
}


$valores=explode(',',$data);
$cordenadas=$valores[3] . "," . $valores[4];

$exludecords['40.0000,-4.0000']=1;



if(($valores[0]=="ES")&&(!$exludecords[$cordenadas])){
$c = curl_init("http://maps.googleapis.com/maps/api/geocode/json?latlng=$cordenadas&sensor=false");
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$geodatos=json_decode($page,TRUE);

$cp=$geodatos[results][0][address_components][5][long_name];
$city=$geodatos[results][0][address_components][1][long_name];
}

return $cp;
	
}


?>