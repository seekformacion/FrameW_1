<?php

if($v[debug]>=3){

foreach($v[debugCSS] as $punt => $deb){$vDBUG[rutas] .="<p>$deb</p>";};$vDBUG[html]="";
echo splitsheet(read_layout(get_path('objt','html','debug/bloque')),'bloque',$vDBUG,$recursividad,'');

}

?>