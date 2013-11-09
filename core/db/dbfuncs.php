<?php

includeCORE('db/db');

function DBselect($queryp){
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$v['conf']['db']);
if (!$dbnivel->open()){die($dbnivel->error());};

$dbnivel->query($queryp);

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();

$cuenta=0;
while ($row = $dbnivel->fetchassoc()){$cuenta++;foreach($row as $campo => $valor){$resultados[$cuenta][$campo]=$valor;};};



if (!$dbnivel->close()){die($dbnivel->error());};	


return $resultados;	
}


function DBUpIns($queryp){
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$v['conf']['db']);
if (!$dbnivel->open()){die($dbnivel->error());};

$dbnivel->query($queryp);

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();


if (!$dbnivel->close()){die($dbnivel->error());};	

	
}



?>