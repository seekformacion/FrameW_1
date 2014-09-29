<?php


function fetch_og($url)
{
    $data = file_get_contents($url);
    $dom = new DomDocument;
    @$dom->loadHTML($data);
     
    $xpath = new DOMXPath($dom);
    # query metatags with og prefix
    $metas = $xpath->query('//*/meta[starts-with(@property, \'og:\')]');

    $og = array();

    foreach($metas as $meta){
        # get property name without og: prefix
        $property = str_replace('og:', '', $meta->getAttribute('property'));
        # get content
        $content = $meta->getAttribute('content');
        $og[$property] = $content;
    }

    return $og;
}


function read_FILE($donde){
$lineas="";	
$fp = fopen($donde, "r");
if($fp){while(!feof($fp)){$lineas.= fgets($fp);};	fclose($fp);};	
return $lineas;	
}





function write_FILE($donde,$content){global $v;
$doit=0;

//echo $donde;
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
		
		#### sustituir  la escritura  de cloud por logear cambios 
		
		#if($v['conf']['mode']==2){
		#$donde2=str_replace($v['path']['httpd'] . "/","",$donde);
		#CLOUDwFILE($donde2,$content);
		#};			
	}


}





function LOCALwFILE($donde,$content){
$fp = fopen($donde, "w");
fwrite($fp, $content); fclose($fp);	
}




function CLOUDwFILE($donde,$content){
includeCORE('initS3/initS3');
$s3 = new S3(awsAccessKey, awsSecretKey, true, 's3-eu-west-1.amazonaws.com');
$s3->putObject($content, 'seekf', $donde, S3::ACL_PUBLIC_READ);	
}



function jsPOSTPROCESS($buscos,$contenido){

foreach ($buscos as $qbusco => $qcambio){$busco[]=$qbusco;$cambio[]=$qcambio;};	
$contenido=str_replace($busco,$cambio,$contenido);

return $contenido;		
}

?>