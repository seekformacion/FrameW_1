<?php

function read_FILE($donde){
$fp = fopen($donde, "r");
if($fp){while(!feof($fp)){$lineas.= fgets($fp);};	fclose($fp);};	
return $lineas;	
}

function write_FILE($donde,$content){

$carpetas=explode('/',$donde); $cuantos=count($carpetas)-1;	
$dir=str_replace("/" . $carpetas[$cuantos],'',$donde);
$carpetas=explode('/',$dir);
$dir2="";

foreach($carpetas as $point => $dir){if($dir){

	$dir2=$dir2 . "/" . $dir;
	if (!is_dir($dir2)){mkdir($dir2);}
}}

	
$fp = fopen($donde, "w");
fwrite($fp, $content); fclose($fp);	

}


?>