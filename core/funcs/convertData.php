<?php

function cforPanel($campos,$idc){
$ncamp=array();	
if(count($campos)>0){foreach ($campos as $idcamp => $valor){


$ncamp[$idcamp]=campforPanel($idcamp,$valor,$idc);			
	
}}
return $ncamp;
}


function campforPanel($cmp,$val,$idc){
$nval=$val;

$res= DBselectSDB("SELECT panel FROM skP_equivals WHERE id_centro=0 AND id_campo=$cmp AND cod='$val';",'seekpanel'); 
if(array_key_exists(1, $res)){$nval=$res[1]['panel'];};
$res= DBselectSDB("SELECT panel FROM skP_equivals WHERE id_centro=$idc AND id_campo=$cmp AND cod='$val';",'seekpanel'); 
if(array_key_exists(1, $res)){$nval=$res[1]['panel'];};


return $nval;	
}


?>