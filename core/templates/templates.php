<?php



################## funcion apertura de archivos ##########
function read_layout($donde){
$fp = fopen($donde, "r");
if($fp){while(!feof($fp)){$lineas[]= fgets($fp);};	fclose($fp);};	
return $lineas;	
}
##########################################################


function splitsheet($file,$obj,$valores,$recursividad){
$agrupo="";	$html="";
	
$queprincipio="<!-- $obj -->";
$quefin="<!-- fin $obj -->";
 											
$valores['enlacescaut']="";#enlacescaut();




foreach($file as $line){
$line=str_replace("\n","",$line);
$line=str_replace("\r","",$line);
$line=trim($line);
											

if($line == $quefin){$agrupo=0;};
if ($agrupo){

			
		
			if($valores){
			foreach($valores as $key => $valor){
			$key="%" .$key . "%";
			$line=str_replace($key,$valor,$line);	
			}}		
				
			$lineas2[]=$line ;


}
if($line == $queprincipio){$agrupo=1;  };

}


if($recursividad){
$html=recursividad($lineas2,$recursividad);	
}else{

if(count($lineas2)>0){	
foreach($lineas2 as $line){
	
	$pattern="<!--(.*)-->";
	$html=preg_replace($pattern,"", $html);
	$html .=$line . "\n";
	
}	}
}

$pattern="<!-- -->";
$html=str_replace($pattern,"", $html);	
return $html;
}


function recursividad($lineas2,$recursividad){
	
$agrupo2=0;
if($recursividad){

	foreach ($recursividad as $que2 => $datos){
		
			
			$queprincipio2="<!-- $que2 -->";
			$quefin2="<!-- fin $que2 -->";
			
			
			
			$lineas3="";
			foreach($lineas2 as $line){
			$line=str_replace("\n","",$line);
			$line=str_replace("\r","",$line);
			$line=trim($line);
			
			if($line == $queprincipio2){$agrupo2=1;};
			
			
			
			
			if (!$agrupo2){
			  	
			  	
			  	if(($line == $queprincipio2)||($line == $quefin2)){}else{$lineas3[]=$line;};
			  	
			  	
			  	
			}else{
				
					if(($line == $queprincipio2)||($line == $quefin2)){}else{$minicodigo[$que2][]=$line . "\n\r";};
		  }	
			
			if($line == $quefin2){$agrupo2=0;$lineas3[]="%$que2%";};
			
		
			
			}
			$lineas2=$lineas3;
			
		
		
	}
	}
#echo "--------------- \n";
#print_r($lineas3);
#print_r($minicodigo);

foreach ($recursividad as $que2 => $valores){
$codigo2="";
$codigo="";


if(count($minicodigo) > 0){foreach ($minicodigo[$que2] as $lineac){$codigo .=$lineac;};};



if( (is_array($valores)) && (count($valores) > 0)){
foreach($valores as $notdo => $cual){
	
$codigo2 .=$codigo;
foreach($cual as $key => $valor){
$key="%" .$key . "%";
$codigo2=str_replace($key,$valor,$codigo2);	
}

}}

$codigotot[$que2]=$codigo2;	
	
}




$html="";	
foreach($lineas3 as $linehtml){
	
	$html .=$linehtml;
	

	}


	
foreach($codigotot as $que => $remplazo){

$busco="%$que%";

$busc=$recursividad[$que];

if(key_exists(0, $busc)){$remplazo="";};

$html=str_replace($busco,$remplazo,$html);		
		
		
	}




return $html;
	
}


?>