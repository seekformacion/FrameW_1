<?php


function getCPLcup($idcup,$idcent,$idcurso){$cpl="";

$datis= DBselectSDB("SELECT pccur FROM skv_cursos WHERE id=$idcurso;",'seekformacion'); 	
if(array_key_exists(1, $datis)){$cpl=$datis[1]['pccur'];};


$CPLAreg=array();
$reglas=DBselectSDB("select atributo, valor, CPL from skP_precios_rule where id_centro=$idcent AND proceso=2 ORDER BY orden ASC",'seekpanel');
if(count($reglas)>0){ foreach ($reglas as $key => $values) {
   	   $atributo=$values['atributo'];
	   $valor=$values['valor'];
	   $CPLn=$values['CPL'];
	
	
	$sekid=DBselectSDB("select seekforID FROM skf_datCupon where id=$idcup;",'seekformacion');
	if(array_key_exists(1, $sekid)){$seekforID=$sekid[1]['seekforID'];};
	
	$cplreg=array();$id=""; 
    $cplreg=DBselectSDB("select id FROM skv_user_data where id_campo=$atributo AND valor $valor AND seekforID='$seekforID';",'seekformacion');
	if(array_key_exists(1, $cplreg)){$cpl=$CPLn;};
	   
}}
		
	
return $cpl;	
}



function sendPIXEL($idcent,$idcupon,$idcurso,$method){
$url=getPixel($idcent,$idcupon,$idcurso,0);	

$page="Prueba - no enviado a centro";

########## envio por GET
if($method==1){
$c = curl_init($url);
curl_setopt($c, CURLOPT_VERBOSE, false);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);	
}
#########################

$url=str_replace('&', "\n&", $url);
#############3 actualizo resultado
DBUpInsSDB("UPDATE skP_cupones SET pixel='$url', result='$page' WHERE id_cupon=$idcupon AND id_curso=$idcurso;",'seekpanel');		
}




function getPixel($idcent,$idcupon,$idcurso,$debug){
$skid="";

$inf2=DBselectSDB("SELECT seekforID FROM skf_datCupon WHERE id=$idcupon;",'seekformacion'); 
if(count($inf2)>0){$skid=$inf2[1]['seekforID'];}



if(($skid)&&($idcent)){
#######3 recuperacion de datos del cupon
$datis= DBselectSDB("SELECT id_campo, valor FROM skv_user_data WHERE seekforID='$skid';",'seekformacion'); 
$datisC=DBselectSDB("SELECT id_campo, valor FROM skv_user_data_cent WHERE seekforID='$skid' AND id_centro=$idcent;",'seekformacion'); 
if(count($datis)>0){foreach($datis as $kk => $vv){$datCup[$vv['id_campo']]=$vv['valor'];}};
if(count($datisC)>0){foreach($datisC as $kk => $vv){$datCup[$vv['id_campo']]=$vv['valor'];}};

if(array_key_exists(12, $datCup)){$datCup[13]=calculaedad($datCup[12]);};
$datCup[45]=$idcupon; #id del cupon

$PdatCup=cforPixel($datCup,$idcent);

##############3 datos que quiere el centro
$datfC= DBselectSDB("SELECT idcampo, bd FROM skv_relCampos WHERE id_centro=$idcent ORDER 
BY FIELD(idcampo,1,2,21,11,18,12,13,4,5,3,8,9,10,6,7,15,16,23,19,14,17,20,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51);",'seekformacion'); 
if(count($datfC)>0){foreach($datfC as $kk => $vv){$datFPCup[$vv['idcampo']]=$vv['bd'];}};



//print_r($datFPCup);
foreach ($datFPCup as $idc => $nom) {
if(array_key_exists($idc, $PdatCup)){$val=$PdatCup[$idc];}else{$val="";}	
if($idc==14){$val=getCurCOD($idcurso,'cd1');}#### recupero id del curso propio cd1;
if($idc==17){$val=getCurCOD($idcurso,'cd2');}#### recupero id del curso propio cd2;
if($idc==36){$val=getCurCOD($idcurso,'cd3');}#### recupero id del curso propio cd3;
if($idc==43){$val=getCurCOD($idcurso,'cd4');}#### recupero id del curso propio cd4;
if($idc==46){$val=getCurIDP($idcurso);}#### recupero id de portal del curso;


$datos[$nom]=$val;	
}

######### checkeo de procesado expecifico del centro y postprocesado generico
global $v;
$nombre_fichero = $v['path']['bin'] . "/allsites/processCUP/$idcent.php";
																				
if (file_exists($nombre_fichero)) {
include($nombre_fichero);if($debug){echo $nombre_fichero;};
}
include($v['path']['bin'] . "/allsites/processCUP/defprocess.php");
#####################################################

$daPIX= DBselectSDB("SELECT pixel FROM skv_relCentPixel WHERE id_centro=$idcent;",'seekformacion'); 
if(count($daPIX)>0){$pixel=$daPIX[1]['pixel'];};

foreach ($datos as $cmpi => $cmpiv) {$cmpiv=urlencode($cmpiv);
$pixel .="&$cmpi=$cmpiv";	
}

if($debug){
echo "\n\n $pixel \n\n";
}else{
return $pixel;
}

}else{

}		
}


function getCurCOD($idcurso,$cod){
$inf2=DBselectSDB("SELECT $cod FROM skP_cursos WHERE id=$idcurso;",'seekpanel'); 
if(count($inf2)>0){$cpro=$inf2[1][$cod];}

return $cpro;	
}

function getCurIDP($idcurso){
$inf2=DBselectSDB("SELECT idp FROM skf_urls WHERE t_id=$idcurso AND tipo=2;",'seekformacion'); 
if(count($inf2)>0){$cpro=$inf2[1]['idp'];}

return $cpro;	
}



function calculaedad($fnaci){
date_default_timezone_set('GMT');	
$cumple=substr($fnaci,0,4) . "-" . substr($fnaci,4,2) . "-" . substr($fnaci,6,2);

$now      = new DateTime();
$birthday = new DateTime("$cumple 00:00:01");
$interval = $now->diff($birthday);
$edad = $interval->format('%y'); 

return $edad;
}


function cforPanel($campos,$idc){
$ncamp=array();	
if(count($campos)>0){foreach ($campos as $idcamp => $valor){


$ncamp[$idcamp]=campforPanel($idcamp,$valor,$idc);			
	
}}
return $ncamp;
}









function campforPanel($cmp,$val,$idc){
$nval=$val;

#####campo fecha de nacimiento
if($cmp==12){
$res= DBselectSDB("SELECT panel FROM skP_equivals WHERE id_centro=0 AND id_campo=$cmp;",'seekpanel'); 
if(array_key_exists(1, $res)){$nval=$res[1]['panel'];};
$res= DBselectSDB("SELECT panel FROM skP_equivals WHERE id_centro=$idc AND id_campo=$cmp;",'seekpanel'); 
if(array_key_exists(1, $res)){$nval=$res[1]['panel'];};		
$nval=str_replace('aaaa',substr($val,0,4),$nval);		
$nval=str_replace('mm',substr($val,4,2),$nval);	
$nval=str_replace('dd',substr($val,6,2),$nval);		





}else{
$res= DBselectSDB("SELECT panel FROM skP_equivals WHERE id_centro=0 AND id_campo=$cmp AND cod='$val';",'seekpanel'); 
if(array_key_exists(1, $res)){$nval=$res[1]['panel'];};
$res= DBselectSDB("SELECT panel FROM skP_equivals WHERE id_centro=$idc AND id_campo=$cmp AND cod='$val';",'seekpanel'); 
if(array_key_exists(1, $res)){$nval=$res[1]['panel'];};
}

return $nval;	
}



function cforPixel($campos,$idc){
$ncamp=array();	
if(count($campos)>0){foreach ($campos as $idcamp => $valor){
$ncamp[$idcamp]=campforPixel($idcamp,$valor,$idc);			
}}
//print_r($ncamp);
return $ncamp;
}





function campforPixel($cmp,$val,$idc){
$nval=$val;

#####campo fecha de nacimiento
if($cmp==12){
$res= DBselectSDB("SELECT pixel FROM skP_equivals WHERE id_centro=0 AND id_campo=$cmp;",'seekpanel'); 
if(array_key_exists(1, $res)){if($res[1]['pixel']!=""){$nval=$res[1]['pixel'];}};
$res= DBselectSDB("SELECT pixel FROM skP_equivals WHERE id_centro=$idc AND id_campo=$cmp;",'seekpanel'); 
if(array_key_exists(1, $res)){if($res[1]['pixel']!=""){$nval=$res[1]['pixel'];}};		
$nval=str_replace('aaaa',substr($val,0,4),$nval);		
$nval=str_replace('mm',substr($val,4,2),$nval);	
$nval=str_replace('dd',substr($val,6,2),$nval);		




}else{
$res= DBselectSDB("SELECT pixel FROM skP_equivals WHERE id_centro=0 AND id_campo=$cmp AND cod='$val';",'seekpanel'); 
if(array_key_exists(1, $res)){if($res[1]['pixel']!=""){$nval=$res[1]['pixel'];}};
$res= DBselectSDB("SELECT pixel FROM skP_equivals WHERE id_centro=$idc AND id_campo=$cmp AND cod='$val';",'seekpanel'); 
echo "SELECT pixel FROM skP_equivals WHERE id_centro=$idc AND id_campo=$cmp AND cod='$val';";
if(array_key_exists(1, $res)){if($res[1]['pixel']!=""){$nval=$res[1]['pixel'];}};
}

if($nval=='cero'){$nval="0";}
return $nval;	
}



?>