<?php

function calculaedad($fnaci){
$cumple=substr($fnaci,0,4) . "-" . substr($fnaci,4,2) . "-" . substr($fnaci,6,2);
//$date = date_create($cumple);
//$interval = $date->diff(new DateTime);
//return $interval->y;	

return $cumple;
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


?>