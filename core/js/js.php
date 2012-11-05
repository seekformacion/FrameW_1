<?php



function createJS(){global $v;
includeCORE('files/files');


##########modo test
if($v[conf][state]==1){
foreach ($v[js] as $point => $ruta){
	


$contenidoJS=read_FILE($ruta);
$contenidoJS=str_replace('%A%',$v[recusi][A], $contenidoJS);
$contenidoJS=str_replace('%B%',$v[recusi][B], $contenidoJS);
$rutaparcial=str_replace($v[path][bin],'', $ruta);


$quitos=array('allsites','/objt','/js/',$v[where][site]);
$rutaparcial=str_replace($quitos,'', $rutaparcial);



$donde=$v[path][httpd] . $v[path][l_js] . $rutaparcial;	
write_FILE($donde,$contenidoJS);
$v[js][urls][]=$v[path][l_js] . $rutaparcial;

}
	
}	
##########modo test


##########modo produccion
if($v[conf][state]==2){
foreach ($v[js] as $point => $ruta){
	

$js=read_FILE($ruta);


$contenidoJS .=$js;

$rutaparcial=str_replace($v[path][bin],'', $ruta);
$quitos=array('allsites','/objt','/css/',$v[where][site]);
$rutaparcial=str_replace($quitos,'', $rutaparcial);
$rutasparciales.= $rutaparcial;


}


$donde=$v[path][httpd] . $v[path][c_js] . "/" . md5($rutasparciales) . ".js";

$reusri[A] .='$(\'#stl_' . $v[recusiSTL] . "[rel=stylesheet]').attr('href', '" . $v[recusi][A] . "'); ";
$reusri[B] .='$(\'#stl_' . $v[recusiSTL] . "[rel=stylesheet]').attr('href', '" . $v[recusi][B] . "'); ";

$contenidoJS=str_replace('%A%',$reusri[A], $contenidoJS);
$contenidoJS=str_replace('%B%',$reusri[B], $contenidoJS);

write_FILE($donde,$contenidoJS);
$v[js][urls][]=$v[path][c_js] . "/" . md5($rutasparciales) . ".js";


	





	
}	
##########modo produccion



	
}









?>


