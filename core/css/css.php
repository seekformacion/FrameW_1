<?php



function createCSS(){global $v;

$IE="";

##########modo test
if($v['conf']['state']==1){


$v['dataCSSfinal']=$v['dataCSS'];
	
}	
##########modo test




##########modo produccion
if($v['conf']['state']==2){


$nomfFinal="";$html="";
foreach ($v['dataCSS']['all'] as $nomfile => $valores) {
$nomfFinal .=$valores['path'] . $nomfile;	
$html .=$valores['html'];	
}
$nomfFinal=md5($nomfFinal);
$v['dataCSSfinal']['all'][$nomfFinal]['path']="";#$v['path']['c_css'];
$v['dataCSSfinal']['all'][$nomfFinal]['html']=$html;
$v['dataCSSfinal']['all'][$nomfFinal]['stl']=0;
$v['dataCSSfinal']['all'][$nomfFinal]['stlname']="";

	
	
$nomfFinal="";$html="";	
foreach ($v['dataCSS']['A'] as $nomfile => $valores) {
$nomfFinal .=$valores['path'] . $nomfile;	
$html .=$valores['html'];	
}
$nomfFinal=md5($nomfFinal);$stl=$nomfFinal;
$v['dataCSSfinal']['A'][$nomfFinal]['path']="/A";#$v['path']['c_css'] . "/A";
$v['dataCSSfinal']['A'][$nomfFinal]['html']=$html;
$v['dataCSSfinal']['A'][$nomfFinal]['stl']=1;
$v['dataCSSfinal']['A'][$nomfFinal]['stlname']=$stl;


$nomfFinal="";$html="";
foreach ($v['dataCSS']['B'] as $nomfile => $valores) {
$nomfFinal .=$valores['path'] . $nomfile;	
$html .=$valores['html'];	
}
$nomfFinal=md5($nomfFinal);
$v['dataCSSfinal']['B'][$nomfFinal]['path']="/B";#$v['path']['c_css'] . "/B";
$v['dataCSSfinal']['B'][$nomfFinal]['html']=$html;
$v['dataCSSfinal']['B'][$nomfFinal]['stl']=0;
$v['dataCSSfinal']['B'][$nomfFinal]['stlname']=$stl;



	
}	
##########modo produccion

$v['linksCSS']=""; $v['linksCSSIE']="";   $v['JSpostPROCESS']['%B%']="";$v['JSpostPROCESS']['%A%']="";
foreach ($v['dataCSSfinal'] as $res => $nombres) {foreach ($nombres as $nombre => $valores){

$ruta=$valores['path'] . "/$nombre.css";

if($v['conf']['state']==1){$basePATH=$v['path']['l_css'];$stl=$nombre;};
if($v['conf']['state']==2){$basePATH=$v['path']['c_css'];$stl=$valores['stlname'];};
	
write_FILE($v['path']['httpd'] . $basePATH . $ruta, $valores['html']);

if($res == "all"){
$v['linksCSS']   .="<link rel='stylesheet' type='text/css' href='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "' id='stl_" . $nombre . "' /> \n";
$v['linksCSSIE'] .="<link rel='stylesheet' type='text/css' href='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "'/> \n";

}
if($res == "A"){
$v['linksCSS'] .="<link rel='stylesheet' type='text/css' media='all and (orientation:landscape)' href='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "' id='stl_" . $nombre . "' /> \n" ;
$v['linksCSSIE'] .="<link rel='stylesheet' type='text/css' href='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "' /> \n";  
  
}		
if($res == "B"){
$v['linksCSS'] .="<link rel='stylesheet' type='text/css' media='all and (orientation:portrait)' href='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "' id='stl_" . $nombre . "' /> \n";
}
	
#if($valores['stl'])	{$v['linksCSS'] .="<link rel='stylesheet' type='text/css' media='all and (orientation:landscape)' href='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "' id='stl_" . $nombre . "' /> \n";}else
#					{$v['linksCSS'] .="<link rel='stylesheet' type='text/css' href='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "' /> \n";};
#}


########### codigo a reemplazar en js
#if($res=="B"){$v['JSpostPROCESS']['%B%'] .=	"$('#stl_" . $stl . "[rel=stylesheet]').attr('href', '" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "'); \n";};
#if($res=="A"){$v['JSpostPROCESS']['%A%'] .=	"$('#stl_" . $stl . "[rel=stylesheet]').attr('href', '" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "'); \n";};	
########### codigo a reemplazar en js

	
}}




#print_r($v[dataCSSfinal]);	
}









?>