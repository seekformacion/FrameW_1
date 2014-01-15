<?php
function createJS(){global $v;

includeCORE('files/files');



##########modo test
if($v['conf']['state']==1){
$v['dataJSfinal']=$v['dataJS'];
}	
##########modo test	



##########modo produccion
if($v['conf']['state']==2){

$nomfFinal="";$html="";
foreach ($v['dataJS']['all'] as $nomfile => $valores) {
$nomfFinal .=$valores['path'] . $nomfile;	
$html .=$valores['html'];	
}
$nomfFinal=md5($nomfFinal);
$v['dataJSfinal']['all'][$nomfFinal]['path']=$v['path']['c_js'];
$v['dataJSfinal']['all'][$nomfFinal]['html']=$html;

}	
##########modo produccion



$v['linksjS']="";
foreach ($v['dataJSfinal'] as $res => $nombres) {foreach ($nombres as $nombre => $valores){
	
	if($res=="all"){
		
		$ruta="/$nombre.js";
		if($v['conf']['state']==1){$basePATH=$v['path']['l_js'];};
		if($v['conf']['state']==2){$basePATH=$v['path']['c_js'];};
		
		$contenido=jsPOSTPROCESS($v['JSpostPROCESS'],$valores['html']);
		//$contenido=$valores['html'];
		write_FILE($v['path']['httpd'] . $basePATH . $ruta,$contenido);
		
			if($res != "B"){
			$v['linksjS'] .="<script type='text/javascript' src='" . $v['path']['baseURLskin'][$v['conf']['mode']] . $basePATH . $ruta . "'></script> \n";
			}
		}

	
}}





	
}









?>