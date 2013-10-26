<?php



function normaliza ($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
	
	$cadena=str_replace(',',' ', $cadena);
	$cadena=str_replace('.',' ', $cadena);
	$cadena=strtolower(trim($cadena));
	$cadena=str_replace(' ','_', $cadena);
	
    return utf8_encode($cadena);
}

	


?>