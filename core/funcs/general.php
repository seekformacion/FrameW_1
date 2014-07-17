<?php

function utf8_encode_deep(&$input) {
    if (is_string($input)) {
        $input = utf8_encode($input);
    } else if (is_array($input)) {
        foreach ($input as &$value) {
            utf8_encode_deep($value);
        }

        unset($value);
    } else if (is_object($input)) {
        $vars = array_keys(get_object_vars($input));

        foreach ($vars as $var) {
            utf8_encode_deep($input->$var);
        }
    }
}


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


function limpiaStr($cadena){
	
	$cadena = strip_punctuation($cadena);
	
    $originales  = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuuyybyRr';
    
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), utf8_decode($modificadas));
    $cadena = strtolower($cadena);
	
	$qq=',.-_():*?¿¡!|;{}&%$#@ºª><+·"';$a=0;
	while ($a < strlen($qq) ){
	$q=substr($qq, $a,1);
	$cadena=str_replace(" $q ",' ', $cadena);
	$cadena=str_replace("$q ",' ', $cadena);
	$cadena=str_replace(" $q",' ', $cadena);
	$cadena=str_replace("$q",' ', $cadena);	
	$a++;
	}

	$cadena=str_replace(' / ',' ', $cadena);
	$cadena=str_replace('/ ',' ', $cadena);
	$cadena=str_replace(' /',' ', $cadena);
	$cadena=str_replace('/',' ', $cadena);
	
	$cadena=str_replace(' \\ ',' ', $cadena);
	$cadena=str_replace('\\ ',' ', $cadena);
	$cadena=str_replace(' \\',' ', $cadena);
	$cadena=str_replace('\\',' ', $cadena);

	
	
	//$cadena = preg_replace("/[^a-zA-Z 0-9]+/", " ", $cadena);
	
	$cadena=strtolower(trim($cadena));
	
	//$cadena=utf8_encode($cadena);
	
	return $cadena;
	
	
   
}
	
function stripAccents($string){

//echo "\n _________ \n $string \n ____-- \n";
$string=utf8_decode($string);
//echo "\n _________ \n $string \n ____-- \n";


$ori=utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ');
$mod=utf8_decode('aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

//echo "\n _________ \n $ori \n ____-- \n";
//echo "\n _________ \n $mod \n ____-- \n";

$new= strtr($string,$ori,$mod);

//echo "\n _________ \n $new \n ____-- \n";
return $new;						
}	
	
	
function strip_punctuation( $text )
{
    $urlbrackets    = '\[\]\(\)';
    $urlspacebefore = ':;\'_\*%@&?!' . $urlbrackets;
    $urlspaceafter  = '\.,:;\'\-_\*@&\/\\\\\?!#' . $urlbrackets;
    $urlall         = '\.,:;\'\-_\*%@&\/\\\\\?!#' . $urlbrackets;
 
    $specialquotes  = '\'"\*<>';
 
    $fullstop       = '\x{002E}\x{FE52}\x{FF0E}';
    $comma          = '\x{002C}\x{FE50}\x{FF0C}';
    $arabsep        = '\x{066B}\x{066C}';
    $numseparators  = $fullstop . $comma . $arabsep;
 
    $numbersign     = '\x{0023}\x{FE5F}\x{FF03}';
    $percent        = '\x{066A}\x{0025}\x{066A}\x{FE6A}\x{FF05}\x{2030}\x{2031}';
    $prime          = '\x{2032}\x{2033}\x{2034}\x{2057}';
    $nummodifiers   = $numbersign . $percent . $prime;
 
    return preg_replace(
        array(
        // Remove separator, control, formatting, surrogate,
        // open/close quotes.
            '/[\p{Z}\p{Cc}\p{Cf}\p{Cs}\p{Pi}\p{Pf}]/u',
        // Remove other punctuation except special cases
            '/\p{Po}(?<![' . $specialquotes .
                $numseparators . $urlall . $nummodifiers . '])/u',
        // Remove non-URL open/close brackets, except URL brackets.
            '/[\p{Ps}\p{Pe}](?<![' . $urlbrackets . '])/u',
        // Remove special quotes, dashes, connectors, number
        // separators, and URL characters followed by a space
            '/[' . $specialquotes . $numseparators . $urlspaceafter .
                '\p{Pd}\p{Pc}]+((?= )|$)/u',
        // Remove special quotes, connectors, and URL characters
        // preceded by a space
            '/((?<= )|^)[' . $specialquotes . $urlspacebefore . '\p{Pc}]+/u',
        // Remove dashes preceded by a space, but not followed by a number
            '/((?<= )|^)\p{Pd}+(?![\p{N}\p{Sc}])/u',
        // Remove consecutive spaces
            '/ +/',
        ),' ',$text );
}

?>