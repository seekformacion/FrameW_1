<?php



function createCSS(){global $v;



##########modo test
if($v[conf][state]==1){


$v[dataCSSfinal]=$v[dataCSS];
	
}	
##########modo test




##########modo produccion
if($v[conf][state]==2){


$nomfFinal="";$html="";
foreach ($v[dataCSS][all] as $nomfile => $valores) {
$nomfFinal .=$valores[path] . $nomfile;	
$html .=$valores[html];	
}
$nomfFinal=md5($nomfFinal);
$v[dataCSSfinal][all][$nomfFinal][path]=$v[path][c_css];
$v[dataCSSfinal][all][$nomfFinal][html]=$html;


	
	
$nomfFinal="";$html="";	
foreach ($v[dataCSS][A] as $nomfile => $valores) {
$nomfFinal .=$valores[path] . $nomfile;	
$html .=$valores[html];	
}
$nomfFinal=md5($nomfFinal);$stl=$nomfFinal;
$v[dataCSSfinal][A][$nomfFinal][path]=$v[path][c_css];
$v[dataCSSfinal][A][$nomfFinal][html]=$html;
$v[dataCSSfinal][A][$nomfFinal][stl]=1;
$v[dataCSSfinal][A][$nomfFinal][stlname]=$stl;


$nomfFinal="";$html="";
foreach ($v[dataCSS][B] as $nomfile => $valores) {
$nomfFinal .=$valores[path] . $nomfile;	
$html .=$valores[html];	
}
$nomfFinal=md5($nomfFinal);
$v[dataCSSfinal][B][$nomfFinal][path]=$v[path][c_css];
$v[dataCSSfinal][B][$nomfFinal][html]=$html;
$v[dataCSSfinal][B][$nomfFinal][stlname]=$stl;



	
}	
##########modo produccion


foreach ($v[dataCSSfinal] as $res => $nombres) {foreach ($nombres as $nombre => $valores){
$sub="";if($res != "all"){$sub="/$res";};	
$ruta="$sub/$nombre.css";

if($v[conf][state]==1){$basePATH=$v[path][l_css];$stl=$nombre;};
if($v[conf][state]==2){$basePATH=$v[path][c_css];$stl=$valores[stlname];};
	
write_FILE($v[path][httpd] . $basePATH . $ruta, $valores[html]);

if($res != "B"){
if($valores[stl])	{$v[linksCSS] .="<link rel='stylesheet' type='text/css' href='" . $v[path][baseURLskin][$v[conf][mode]] . $basePATH . $ruta . "' id='stl_" . $nombre . "' /> \n";}else
					{$v[linksCSS] .="<link rel='stylesheet' type='text/css' href='" . $v[path][baseURLskin][$v[conf][mode]] . $basePATH . $ruta . "' /> \n";};
}


########### codigo a reemplazar en js
if($res=="B"){$v[JSpostPROCESS]['%B%'] .=	"$('#stl_" . $stl . "[rel=stylesheet]').attr('href', '" . $v[path][baseURLskin][$v[conf][mode]] . $basePATH . $ruta . "'); \n";};
if($res=="A"){$v[JSpostPROCESS]['%A%'] .=	"$('#stl_" . $stl . "[rel=stylesheet]').attr('href', '" . $v[path][baseURLskin][$v[conf][mode]] . $basePATH . $ruta . "'); \n";};	
########### codigo a reemplazar en js

	
}}




#print_r($v[dataCSSfinal]);	
}









?>


