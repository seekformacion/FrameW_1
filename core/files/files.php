<?php

function read_FILE($donde){
$lineas="";	
$fp = fopen($donde, "r");
if($fp){while(!feof($fp)){$lineas.= fgets($fp);};	fclose($fp);};	
return $lineas;	
}





function write_FILE($donde,$content){
$doit=0;

if(file_exists($donde)){
	
	if(md5_file($donde)!=md5($content)){$doit=1;}	

}else{

	$carpetas=explode('/',$donde); $cuantos=count($carpetas)-1;	
	$dir=str_replace("/" . $carpetas[$cuantos],'',$donde);
	$carpetas=explode('/',$dir);
	$dir2="";
	
		foreach($carpetas as $point => $dir){if($dir){
			$dir2=$dir2 . "/" . $dir;
			if (!is_dir($dir2)){mkdir($dir2);}
	}}	
	
$doit=1;	
}


	if($doit>0){
	LOCALwFILE($donde,$content);	
	CLOUDwFILE($donde,$content);			
	}


}





function LOCALwFILE($donde,$content){
$fp = fopen($donde, "w");
fwrite($fp, $content); fclose($fp);	
}




function CLOUDwFILE($donde,$content){
	
}



function jsPOSTPROCESS($buscos,$contenido){

foreach ($buscos as $qbusco => $qcambio){$busco[]=$qbusco;$cambio[]=$qcambio;};	
$contenido=str_replace($busco,$cambio,$contenido);
return $contenido;		
}

?>