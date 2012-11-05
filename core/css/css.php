<?php



function createCSS(){global $v;
includeCORE('files/files');


##########modo test
if($v[conf][state]==1){
foreach ($v[css] as $res => $css) {foreach ($css as $point => $ruta){
	
if($res=="all"){$res="";};
$contenidoCSS=read_FILE($ruta);

$rutaparcial=str_replace($v[path][bin],'', $ruta);
$quitos=array('allsites','/objt','/css/',$v[where][site]);
$rutaparcial=str_replace($quitos,'', $rutaparcial);
if($v[debug]>=3){$v[debugCSS][]="$rutaparcial --> $ruta";};

$donde=$v[path][httpd] . $v[path][l_css] . $rutaparcial;	
write_FILE($donde,$contenidoCSS);
$v[css][urls][$res][]=$v[path][l_css] . $rutaparcial;

$stls=explode('/',$rutaparcial);$num=count($stls)-1;$stl=str_replace('.','_',$stls[$num]);
if($res=="A"){$cunta++;$v[recusi][A] .='$(\'#stl_' . $stl . "[rel=stylesheet]').attr('href', '" . $v[path][l_css] . $rutaparcial . "'); ";};
if($res=="B"){$cuntb++;$v[recusi][B] .='$(\'#stl_' . $stl . "[rel=stylesheet]').attr('href', '" . $v[path][l_css] . $rutaparcial . "'); ";};
}}
	
}	
##########modo test


##########modo produccion
if($v[conf][state]==2){
foreach ($v[css] as $res => $css) {foreach ($css as $point => $ruta){
	
if($res=="all"){$res="";};
$contenidoCSS[$res].= read_FILE($ruta);

$rutaparcial=str_replace($v[path][bin],'', $ruta);
$quitos=array('allsites','/objt','/css/',$v[where][site]);
$rutaparcial=str_replace($quitos,'', $rutaparcial);
$rutasparciales[$res] .=$rutaparcial;
if($v[debug]>=3){$v[debug][css][]="$rutaparcial --> $ruta";};

}}

foreach ($rutasparciales as $res => $rutaparcial) {
$sub="";	
if($res != ""){$sub="$res/";};	
$donde=$v[path][httpd] . $v[path][c_css] . "/$sub" . md5($rutaparcial) . ".css";

write_FILE($donde,$contenidoCSS[$res]);
$v[css][urls][$res][]=$v[path][c_css] . "/$sub" . md5($rutaparcial) . ".css";
$v[recusi][$res]=$v[path][c_css] . "/$sub" . md5($rutaparcial) . ".css";
if($res=="A"){$v[recusiSTL]=md5($rutaparcial) . "_css";};


}
	





	
}	
##########modo produccion



	
}









?>


