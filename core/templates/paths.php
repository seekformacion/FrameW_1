<?php

function loadIMGCat($tamaño){

$img="$tamaño/imgcat.jpg";
$img=loadIMG($img);	
return $img;
}

function loadLogoCent($img){global $v;

$ruta="";

if( strlen( str_replace("/",'',$img) ) < strlen($img) ){$imgs=explode('/',$img); $folder=$imgs[0]; $img=$imgs[1];$img="$folder/$img";};
$donde=$v['path']['img'] . "/" . "global/logos/" . $img;
if (file_exists($donde)) {$ruta=$donde;} 


if($v['conf']['mode']==1){$ruta=str_replace($v['path']['img'],$v['path']['localBasePathimg'],$ruta);};
if($v['conf']['mode']==2){$ruta=str_replace($v['path']['img'],$v['path']['cloudBasePathimg'],$ruta);};



return $ruta;

}




function loadIMG($img){global $v;
$ruta="";

if( strlen( str_replace("/",'',$img) ) < strlen($img) ){$imgs=explode('/',$img); $folder=$imgs[0]; $img=$imgs[1];$img="$folder/$img";};



 
$donde=$v['path']['img'] . "/" . "global/allviews/" . $img;
if (file_exists($donde)) {$ruta=$donde;} 

$donde=$v['path']['img'] . "/" . "global/" . $v['where']['view'] . "/allids" ."/" . $img;
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['img'] . "/" . "global/" . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $img ;
if (file_exists($donde)) {$ruta=$donde;} 


$donde=$v['path']['img'] . "/" . $v['where']['site'] . "/allviews/" . $img;
if (file_exists($donde)) {$ruta=$donde;} 
$donde=$v['path']['img'] . "/" . $v['where']['site'] . $v['where']['view'] . "/allids" ."/" . $img;
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['img'] . "/" . $v['where']['site'] . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $img;
if (file_exists($donde)) {$ruta=$donde;} 


if($v['conf']['mode']==1){$ruta=str_replace($v['path']['img'],$v['path']['localBasePathimg'],$ruta);};
if($v['conf']['mode']==2){$ruta=str_replace($v['path']['img'],$v['path']['cloudBasePathimg'],$ruta);};


if($v['debug']>=4){echo "$ruta<br>"; };


return $ruta;

}





function get_path($tipo,$ext,$objeto){global $v;
$ruta="";

if( strlen( str_replace("/",'',$objeto) ) < strlen($objeto) ){$objetos=explode('/',$objeto); $folder=$objetos[0]; $objeto=$objetos[1];$objeto="$folder/$objeto";};


$donde=$v['path']['fw'] . "/$tipo/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;};

 
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/" . $ext . "/allviews/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} #echo $donde . "\n";
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/" . $ext . "/" . $v['where']['view'] . "/allids" ."/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} #echo $donde . "\n";
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/" . $ext . "/" . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} #echo $donde . "\n";


$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/" . $ext . "/allviews/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} #echo $donde . "\n";
$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/" . $ext . "/" . $v['where']['view'] . "/allids" ."/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} #echo $donde . "\n";
$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/" . $ext . "/" . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $objeto . ".$ext";
if (file_exists($donde)) {$ruta=$donde;} #echo $donde . "\n";

#echo "_______________________________________\n";
#echo $ruta . "\n";
#echo "_______________________________________\n";
if($v['debug']>=4){echo "$ruta<br>"; };
return $ruta;

}




function get_pathCSS($tipo,$objeto){global $v;
$ruta="";

if( strlen( str_replace("/",'',$objeto) ) < strlen($objeto) ){$objetos=explode('/',$objeto); $folder=$objetos[0]; $objeto=$objetos[1];$objeto="$folder/$objeto";};


$donde=$v['path']['fw'] . "/$tipo/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}

 
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/css/allviews/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;};
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/css/" . $v['where']['view'] . "/allids" ."/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/css/" . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;} 


$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/css/allviews/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/css/" . $v['where']['view'] . "/allids" ."/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/css/" . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $objeto . ".css";
if (file_exists($donde)) {$ruta=$donde;} 

if($v['debug']>3){echo "$ruta <br>\n";};
return $ruta;   

}



function get_pathJS($tipo,$objeto){global $v;
$ruta="";

if( strlen( str_replace("/",'',$objeto) ) < strlen($objeto) ){$objetos=explode('/',$objeto); $folder=$objetos[0]; $objeto=$objetos[1];$objeto="$folder/$objeto";};


$donde=$v['path']['fw'] . "/$tipo/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}

 
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/js/allviews/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}; #echo "$donde <br>";
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/js/" . $v['where']['view'] . "/allids" ."/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['bin'] . "/" . "allsites" . "/" . $tipo . "/js/" . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;} 


$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/js/allviews/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/js/" . $v['where']['view'] . "/allids" ."/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;}
$donde=$v['path']['bin'] . "/" . $v['where']['site'] . "/" . $tipo . "/js/" . $v['where']['view'] . "/ID" . $v['where']['id'] . "/" . $objeto . ".js";
if (file_exists($donde)) {$ruta=$donde;} 

if($v['debug']>=4){echo "$ruta<br>"; };
return $ruta;

}



function splitRUTA($ruta){global $v;
$rutas['fpath']=$ruta;
$valores=explode('/',$ruta); $num=count($valores)-1;
$file=$valores[$num];
$files=explode('.',$file);
$rutas['nom']=$files[0];
$path=str_replace("/" . $file,'', $ruta);	
$path=str_replace($v['path']['bin'],'', $path);$path=str_replace($v['path']['fw'],'', $path);
$rutas['path']=$path;


return $rutas;	
}





function loadCSS($tipo,$objeto){global $v;
includeCORE('files/files');
$rutas=get_pathCSS($tipo,$objeto);	 #$valoresDBUG[rutas] .="<p>$rutas</p>";	

if($rutas){
$files=splitRUTA($rutas);
$v['dataCSS']['all'][$files['nom']]['path']=$files['path'];
$v['dataCSS']['all'][$files['nom']]['html']=read_FILE($files['fpath']);
$v['dataCSS']['all'][$files['nom']]['stl']=0;
}


foreach ($v['conf']['resolution'] as $res => $value) {
$rutas=get_pathCSS($tipo,"$res/" . $objeto);	
		if($rutas){
		$files=splitRUTA($rutas);
		$v['dataCSS'][$res][$files['nom']]['path']=$files['path'];
		$v['dataCSS'][$res][$files['nom']]['html']=read_FILE($files['fpath']);
		if($res=="A"){$v['dataCSS'][$res][$files['nom']]['stl']=1;}else{$v['dataCSS'][$res][$files['nom']]['stl']=0;};
		}
}


}




function loadJS($tipo,$objeto){global $v;

includeCORE('files/files');
$rutas=get_pathJS($tipo,$objeto);	 #$valoresDBUG[rutas] .="<p>$rutas</p>";	

if($rutas){
$files=splitRUTA($rutas);
$v['dataJS']['all'][$files['nom']]['path']=$files['path'];
$v['dataJS']['all'][$files['nom']]['html']=read_FILE($files['fpath']);
}


}




function includeCORE($func){global $v;

$ruta=get_path('core', 'php', $func);

require_once $ruta;
	
}


function includeFUNC($func){global $v;

$ruta=get_path('func', 'php', $func);

require_once $ruta;
	
}

function includeINIT($func){global $v;

$ruta=get_path('init', 'php', $func);

require_once $ruta;
	
}



function loadChild($tipo,$objeto){global $v;


$Datos=array();$rDatos="";$recursividad="";
$valoresDBUG['rutas']="";
loadCSS($tipo,$objeto);
loadJS($tipo,$objeto);

$rutaPHP=get_path($tipo,'php',$objeto);										$valoresDBUG['rutas'] .="<p>$rutaPHP</p>";
if($rutaPHP){include($rutaPHP);};


$rutaHTML=get_path($tipo,'html',$objeto); 									$valoresDBUG['rutas'] .="<p>$rutaHTML</p>";


$html=splitsheet(read_layout($rutaHTML),$objeto,$Datos,$rDatos); 
if(array_key_exists('codNULL', $Datos)){$html="";};
if(array_key_exists('H_redirect', $Datos)){
$url=$Datos['redirect'];
echo $url;

//header("Location: $url", TRUE, 303);
$html="";
};
													
if(array_key_exists('ALTbloq', $Datos)){$html=$Datos['ALTbloq'];};							$valoresDBUG['html']=$html;


if($v['debug']>0){$html=splitsheet(read_layout(get_path('objt','html','debug/bloque')),'bloque',$valoresDBUG,$recursividad,''); $valoresDBUG['html']=$html;}

	
return $html;	
}

?>