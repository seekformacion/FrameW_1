<?php


function get_path($tipo,$ext,$objeto){global $v;


if( strlen( str_replace("/",'',$objeto) ) < strlen($objeto) ){$objetos=explode('/',$objeto); $folder=$objetos[0]; $objeto=$objetos[1];$objeto="$folder/$objeto";};


if($tipo=="func"){
$donde=$v[path][fw] . "/func/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;}
}
 
$donde=$v[path][bin] . "/" . "allsites" . "/" . $tipo . "/" . $ext . "/allviews/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;}
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



return $ruta;

}


function includeFUNC($func){global $v;

$ruta=get_path('func', 'php', $func);

require_once $ruta;
	
}


function loadChild($tipo,$objeto){global $v;


$rutaPHP=get_path($tipo,'php',$objeto);										$valoresDBUG[rutas] .="<p>$rutaPHP</p>";
require_once $rutaPHP;

$rutaHTML=get_path($tipo,'html',$objeto); 									$valoresDBUG[rutas] .="<p>$rutaHTML</p>";
$html=splitsheet(read_layout($rutaHTML),$objeto,$Datos,$rDatos); 			$valoresDBUG[html]=$html;



if($v[debug]>0){$html=splitsheet(read_layout(get_path('objt','html','debug/bloque')),'bloque',$valoresDBUG,$recursividad,''); $valoresDBUG[html]=$html;}

	
return $html;	
}

?>