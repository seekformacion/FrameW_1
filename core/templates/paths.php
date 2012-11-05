<?php


function get_path($tipo,$ext,$objeto){global $v;


if( strlen( str_replace("/",'',$objeto) ) < strlen($objeto) ){$objetos=explode('/',$objeto); $folder=$objetos[0]; $objeto=$objetos[1];$objeto="$folder/$objeto";};


$donde=$v[path][fw] . "/$tipo/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;}; #echo "$donde <br>";

 
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/" . $ext . "/allviews/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} #echo "$donde <br>";
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/" . $ext . "/" . $v[where][view] . "/allids" ."/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/" . $ext . "/" . $v[where][view] . "/ID" . $v[where][id] . "/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} 


$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/" . $ext . "/allviews/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/" . $ext . "/" . $v[where][view] . "/allids" ."/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/" . $ext . "/" . $v[where][view] . "/ID" . $v[where][id] . "/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} 


if($v[debug]>=4){echo "$ruta<br>"; };
return $ruta;

}




function get_pathCSS($tipo,$objeto){global $v;


if( strlen( str_replace("/",'',$objeto) ) < strlen($objeto) ){$objetos=explode('/',$objeto); $folder=$objetos[0]; $objeto=$objetos[1];$objeto="$folder/$objeto";};


$donde=$v[path][fw] . "/$tipo/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}

 
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/css/allviews/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}; #echo "$donde <br>";
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/css/" . $v[where][view] . "/allids" ."/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/css/" . $v[where][view] . "/ID" . $v[where][id] . "/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;} 


$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/css/allviews/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/css/" . $v[where][view] . "/allids" ."/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/css/" . $v[where][view] . "/ID" . $v[where][id] . "/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;} 


return $ruta;

}



function get_pathJS($tipo,$objeto){global $v;


if( strlen( str_replace("/",'',$objeto) ) < strlen($objeto) ){$objetos=explode('/',$objeto); $folder=$objetos[0]; $objeto=$objetos[1];$objeto="$folder/$objeto";};


$donde=$v[path][fw] . "/$tipo/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}

 
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/js/allviews/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}; #echo "$donde <br>";
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/js/" . $v[where][view] . "/allids" ."/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/js/" . $v[where][view] . "/ID" . $v[where][id] . "/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;} 


$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/js/allviews/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/js/" . $v[where][view] . "/allids" ."/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v[path][bin] . "/" . $v[where][site] . "/" . $tipo . "/js/" . $v[where][view] . "/ID" . $v[where][id] . "/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;} 

if($v[debug]>=4){echo "$ruta<br>"; };
return $ruta;

}







function loadCSS($tipo,$objeto){global $v;

$rutas=get_pathCSS($tipo,$objeto);	 #$valoresDBUG[rutas] .="<p>$rutas</p>";	
if($rutas){$v[css][all][]=$rutas;};

foreach ($v[conf][resolution] as $res => $value) {
$rutas=get_pathCSS($tipo,"$res/" . $objeto);	
if($rutas){$v[css][$res][]=$rutas;};
}


#if($v[debug]>0){$html=splitsheet(read_layout(get_path('objt','html','debug/bloque')),'bloque',$valoresDBUG,$recursividad,''); $valoresDBUG[html]=$html;}
}

function loadJS($tipo,$objeto){global $v;

$rutas=get_pathJS($tipo,$objeto);	 #$valoresDBUG[rutas] .="<p>$rutas</p>";
	
if($rutas){$v[js][]=$rutas;};


#if($v[debug]>0){$html=splitsheet(read_layout(get_path('objt','html','debug/bloque')),'bloque',$valoresDBUG,$recursividad,''); $valoresDBUG[html]=$html;}
}




function includeCORE($func){global $v;

$ruta=get_path('core', 'php', $func);

require_once $ruta;
	
}


function includeFUNC($func){global $v;

$ruta=get_path('func', 'php', $func);

require_once $ruta;
	
}




function loadChild($tipo,$objeto){global $v;


loadCSS($tipo,$objeto);
loadJS($tipo,$objeto);

$rutaPHP=get_path($tipo,'php',$objeto);										$valoresDBUG[rutas] .="<p>$rutaPHP</p>";
include($rutaPHP);


$rutaHTML=get_path($tipo,'html',$objeto); 									$valoresDBUG[rutas] .="<p>$rutaHTML</p>";

$html=splitsheet(read_layout($rutaHTML),$objeto,$Datos,$rDatos); 			$valoresDBUG[html]=$html;



if($v[debug]>0){$html=splitsheet(read_layout(get_path('objt','html','debug/bloque')),'bloque',$valoresDBUG,$recursividad,''); $valoresDBUG[html]=$html;}

	
return $html;	
}

?>