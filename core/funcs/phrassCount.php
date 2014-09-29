<?php 

function borraSP($str){
	
//$str=html_entity_decode($str);
$str = str_replace("\xc2\xa0", ' ', $str);

$str = str_replace("\n", ' ', $str);
$str = str_replace("\t", ' ', $str);

$str=limpiaStr($str);
	


$str = preg_replace('!\s+!', ' ', $str);
$str = preg_replace('!\r+!', ' ', $str);
$str = preg_replace('!\n+!', ' ', $str);
$str = preg_replace('!\t+!', ' ', $str);





echo "\n__________________________\n";
echo $str;
echo "\n__________________________\n";		


return $str;	

}

function noHTML($str){
//$quitos=array('<p>','<br>','<str>','</p>','</br>','</str>','&bull;');
$str=str_replace('><', '> <', $str);
$str=strip_tags($str);

$str=html_entity_decode($str, ENT_COMPAT, 'UTF-8');	

return $str;	
}



function limpiaCur($idcur){global $v;
$sidc=substr($idcur,0,3);

$nnpp=1;
while($nnpp <=3){
$tkey=DBselectSDB("SELECT itable FROM relK_$sidc WHERE tipo=2  AND t_id=$idcur;",'seek_engine_' . $nnpp); 	

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],'seek_engine_' . $nnpp);
if (!$dbnivel->open()){die($dbnivel->error());};

if(count($tkey)>0){foreach($tkey as $kk => $val){$itable=$val['itable'];

$dbnivel->query("DELETE FROM md5_$itable where tipo=2 AND t_id=$idcur;");
if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();
$error=$dbnivel->error();
echo "borrado de tabla $itable \n";


}}

$dbnivel->query("DELETE FROM relK_$sidc where tipo=2 AND t_id=$idcur;");
if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();
$error=$dbnivel->error();

if (!$dbnivel->close()){die($dbnivel->error());};
$nnpp++;
}




	
}

function search_STR($idp,$str){ $result['c']=0; 
$md5=md5($str); $kmd5=substr($md5,0,3);

$tkey=DBselectSDB("SHOW TABLES LIKE 'str_$kmd5';",'seek_engSTR'); 	
if(!array_key_exists(1, $tkey)){
	
/*	
DBUpInsSDB("CREATE TABLE `str_$kmd5` (
		   `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,                                    
           `md5` varchar(255) NOT NULL,                              
           `idp` int(10) DEFAULT NULL,                               
           `id_cat` bigint(255) DEFAULT NULL,                        
           `cache` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,  
           PRIMARY KEY (`id`),
           KEY (`md5`),                                      
           KEY `idp` (`idp`)                                         
         ) ENGINE=InnoDB DEFAULT CHARSET=latin1;",'seek_engSTR');	
*/

}else{
$res=DBselectSDB("SELECT cache from str_$kmd5 WHERE md5='$md5' AND idp=$idp;",'seek_engSTR'); 	
if(array_key_exists(1, $res)){$result['c']=1; $result['cache']=$res[1]['cache'];}	
}


return $result;	
}


function insert_STR($idp,$idc,$str,$cache){
$md5=md5($str); $kmd5=substr($md5,0,3); $ldate=(date('Y') . date('m') . date('d') . date('H') . date('i') . date('s'))*1;

##### creo tabla si no existe
###	
//echo "SHOW TABLES LIKE 'md5_$keyT';";
$tkey=DBselectSDB("SHOW TABLES LIKE 'str_$kmd5';",'seek_engSTR'); 	
if(count($tkey)==0){ //print_r($tkey); echo count($tkey);
DBUpInsSDB("CREATE TABLE `str_$kmd5` (
		   `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,                                    
           `md5` varchar(255) NOT NULL,                              
           `idp` int(10) DEFAULT NULL,                               
           `id_cat` bigint(255) DEFAULT NULL,                        
           `cache` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,  
           PRIMARY KEY (`id`),
           KEY (`md5`),                                      
           KEY `idp` (`idp`)                                         
         ) ENGINE=InnoDB DEFAULT CHARSET=latin1;",'seek_engSTR');	
}

$res=DBselectSDB("SELECT cache from str_$kmd5 WHERE md5='$md5' AND idp=$idp;",'seek_engSTR'); 	
if(array_key_exists(1, $res)){

DBUpInsSDB("UPDATE str_$kmd5 SET cache='$cache' WHERE md5='$md5' AND idp=$idp;;",'seek_engSTR');
DBUpInsSDB("UPDATE cache_str SET ldate=$ldate WHERE str='$str' AND idp=$idp;;",'seek_engSTR');		
	
}else{
	
DBUpInsSDB("INSERT INTO str_$kmd5 (md5,idp,id_cat,cache) VALUES ('$md5',$idp,$idc,'$cache');",'seek_engSTR');
DBUpInsSDB("INSERT INTO cache_str (str,idp,id_cat,ldate) VALUES ('$str',$idp,$idc,$ldate);",'seek_engSTR');	
	
}	

#################################
###




}




function processCUR($idcur){$categoria="";$nombre="";$idp="";


$dcur=DBselect("select nombre, cur_descripcion, 
cur_dirigidoa, cur_paraqueteprepara, temario, 
cur_cat, cur_palclave from skv_cursos where id=$idcur;");
if(array_key_exists(1, $dcur)){
$idcat=$dcur[1]['cur_cat'];

$dcat=DBselect("select idp, pagTittle from skf_urls where t_id=$idcat AND tipo=1;");
if(array_key_exists(1, $dcat)){
$categoria=	$dcat[1]['pagTittle'];
$idp=	$dcat[1]['idp'];		
}


$nombre = " " . borraSP(noHTML($dcur[1]['nombre']));

$categoria = " " . borraSP(noHTML($categoria));
$categoria.= " " . borraSP(noHTML($dcur[1]['cur_palclave']));	

$resto  = " " . borraSP(noHTML($dcur[1]['cur_descripcion']));	
$resto .= " " . borraSP(noHTML($dcur[1]['cur_dirigidoa']));
$resto .= " " . borraSP(noHTML($dcur[1]['cur_paraqueteprepara']));
$resto .= " " . borraSP(noHTML($dcur[1]['temario']));
	
}

$result[1]=array();
$result[2]=array();
$result[3]=array();

if($categoria){
$dnom=phraseC($categoria,1,2,1,3); $ratio=10;			
foreach ($dnom['w'] as $nkw => $vals) { foreach ($vals as $pal => $porc) {//$pal=utf8_encode($pal);
if(array_key_exists($pal, $result[$nkw])){ $result[$nkw][$pal]=$result[$nkw][$pal] + ($porc*$ratio); }else{$result[$nkw][$pal]=$porc*$ratio;};		
}}
}

if($nombre){
$dnom=phraseC($nombre,1,2,1,3); $ratio=20;			
foreach ($dnom['w'] as $nkw => $vals) { foreach ($vals as $pal => $porc) {//$pal=utf8_encode($pal);
if(array_key_exists($pal, $result[$nkw])){ $result[$nkw][$pal]=$result[$nkw][$pal] + ($porc*$ratio); }else{$result[$nkw][$pal]=$porc*$ratio;};		
}}
}

if($resto){
$dnom=phraseC($resto,1,2,1,3); $ratio=1;			
foreach ($dnom['w'] as $nkw => $vals) { foreach ($vals as $pal => $porc) {//$pal=utf8_encode($pal);
if(array_key_exists($pal, $result[$nkw])){ $result[$nkw][$pal]=$result[$nkw][$pal] + ($porc*$ratio); }else{$result[$nkw][$pal]=$porc*$ratio;};		
}}
}

//asort($result[1]);
//asort($result[2]);
//asort($result[3]);

//print_r($result[1]);
if($idp){
$r=insertKEY($result,$idp,2,$idcur);
}else{
$r="";	
}

return $r;	
}


function insertKEY($pals,$idp,$tipo,$idins){$prev=0;global $v;

foreach ($pals as $n => $pallss) {
foreach ($pallss as $pal => $peso) {
	
//echo "$pal \n";	
$md5=base_convert(md5($pal),16,11); $g3=substr("$md5",0,3);	
$grupo[$n][$g3][$md5]['p']=$peso;
//$grupo[$g3][$md5]['n']=$n;		
$grupo[$n][$g3][$md5]['pal']=$pal;
}}


foreach ($grupo as $nnpp => $vgrupo) {
	


$tablasV[$nnpp]="";
############# una sola conexion
$dbnivel2=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],'seek_engine_' . $nnpp);
if (!$dbnivel2->open()){die($dbnivel2->error());};
#############################
foreach ($vgrupo as $keyT => $vals) {
	
if(!$prev){

$tablasV[$nnpp].="(2,$idins,'$keyT'),";	

/*
###
$resultadosa=array();	
//echo "SHOW TABLES LIKE 'md5_$keyT';";
$dbnivel2->query("SHOW TABLES LIKE 'md5_$keyT';");
if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel2->error();
$cuenta=0;
while ($row = $dbnivel2->fetchassoc()){$cuenta++;foreach($row as $campo => $valor){$resultadosa[$cuenta][$campo]=$valor;};};



if(!array_key_exists(1, $resultadosa)){
$dbnivel2->query("CREATE TABLE `md5_$keyT` (                            
             `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,  
             `md5` varchar(255) DEFAULT NULL,                    
             `idp` int(5) DEFAULT NULL,                          
             `tipo` int(5) DEFAULT NULL,                         
             `t_id` int(20) DEFAULT NULL,                        
             `peso` decimal(10,8) DEFAULT NULL,                  
             PRIMARY KEY (`id`),                                 
             KEY `md5` (`md5`),                                  
             KEY `idp` (`idp`),                                  
             KEY `tipo` (`tipo`),                                
             KEY `peso` (`peso`)                                 
           ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel2->error();
$error=$dbnivel2->error();


}
###
*/

}


$datos="";
foreach ($vals as $idpal => $subD) {$peso=$subD['p']; $tpal=$subD['pal']; // $np=$subD['n']; 
$datos .="('$idpal',$idp,$tipo,$idins,'$peso'),";	
}
$datos=substr($datos,0,-1);


########## ejecucion de insters en tablas
if(!$prev){
$dbnivel2->query("INSERT INTO md5_$keyT (md5,idp,tipo,t_id,peso) VALUES $datos;");
if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel2->error();
$error=$dbnivel2->error();
}	
###########################################


}

if (!$dbnivel2->close()){die($dbnivel2->error());};
############ cierro conexion unica
}



################################ tablas KEY_CURSO
$sidc=substr($idins,0,3);

foreach ($tablasV as $nnpp => $tablasVV) {

$tkey=DBselectSDB("SHOW TABLES LIKE 'relK_$sidc';",'seek_engine_' . $nnpp); 	
if(!array_key_exists(1, $tkey)){
DBUpInsSDB("CREATE TABLE `relK_$sidc` (                             
            `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,  
            `tipo` int(10) DEFAULT NULL,                        
            `t_id` bigint(255) DEFAULT NULL,                    
            `itable` varchar(10) DEFAULT NULL,                   
            PRIMARY KEY (`id`),                                 
            KEY `tipo` (`tipo`),                                
            KEY `t_id` (`t_id`),                                
            KEY `itable` (`itable`)                               
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;",'seek_engine_' . $nnpp);	
}



$tablasVV=substr($tablasVV, 0,-1);
//echo "\nINSERT INTO relK_$sidc (tipo,t_id,table) VALUES $tablasV;\n";
DBUpInsSDB("INSERT INTO relK_$sidc (tipo,t_id,itable) VALUES $tablasVV;",'seek_engine_' . $nnpp);
#################################
}


return $idins;
	
}


function phraseC($file,$minfreq,$minchars,$minseq,$maxseq){

$excludes[1] = array();#('todas','todos','vez','mismo','lo','tan','sus','como','todo','toda','han','su','por','pero','ser','es','como','asi','ya','curso','cursos','master','masters','oposicion','oposiciones','grado','grados','fp','les','las','que','se','no','te','tu','contigo','o','a','ante','bajo','cabe ','con','contra','de','desde','en','entre','hacia','hasta','para','por','segun','sin','so','sobre','tras ','durante','mediante','excepto','salvo','incluso','mas','menos','el','la','los','la','un','una','unos','unas','al','del','mio','mios','mia','mias','tuyo','tuyos','tuya','tuyas','suyo','suyos','suya','suyas','nuestro','nuestros','nuestras','nuestra','vuestro','vuestros','vuestra','vuestras','suyo','suyos','suya','suyas','este','ese','aquel','estos','esos','aquellos','esta','esa','aquella','estas','esas','aquellas'); 
$excludes[2] = array();#('una vez','en la','en el','que es','lo que','no se','como en','de una','de un','como el','el mismo','todo en','sobre todo','que no','es el','de los','de las','en los','en las','de la'); 
$excludes[3] = array();#('post','topic','http','www','com'); 
$excludes[4] = array();#'post','topic','http','www','com'); 

$a=1;
while ($a <= 4) {
$pno=DBselectSDB("SELECT pal from contador_$a WHERE ex=1;",'seek_keys'); 
if(count($pno)>0){foreach ($pno as $kk => $vnos){$palno=$vnos['pal'];
$excludes[$a][]=$palno; 	
}}else{
$excludes[$a]=array();	
}

$a++;	
}



//print_r($excludes);

$file=str_replace("\n"," ", $file);
//$file = limpiaStr ($file);
//$file = borraSP ($file);
$file=strtolower(trim($file));
//echo $file . "\n";
     
    //$comm = array_unique(preg_split("(\b\W+\b)", file_get_contents("common_words.txt"))); 
    $comm=array();
	
    $source = explode(" ", $file); 
    $ignore = array(0 => 'post','topic','http','www','com'); 
    $num_ignore = count($ignore); 
     
	
	 
    foreach ($source as $w) 
        { 
        if (strlen($w) >= $minchars) 
        //if (!preg_match("/\A\d+\Z/", $w)) 
        if (!preg_match("/\A(\w)\1+\Z/", $w)) 
        if (!in_array($w, $comm)) 
        if (!in_array($w, $ignore)) 
            { 
            $words[] = $w; 
            } 
        } 
    $num_words = count($words); 
    $result2['nw']=$num_words;     
 


$start = microtime(true); 
$str = strtolower(implode(' ', $words));
//echo $str . "\n";
 
$seqs = array(); 
for ($i = 0; $i < $num_words; $i ++) // for each word 
        { 
        for ($j = $maxseq; $j >= $minseq; $j --) // seq word counts 
            { 
            $try = $words[$i]; 
	            if ($j > 1) 
	                { 
	                for ($k = 1; $k < $j; $k ++) // fetch words to try 
	                    {
		                    if(array_key_exists(($i + $k), $words)){	 
		                    $try .= ' ' . $words[$i + $k]; 
							}
						} 
	        
			        } 
            
            //echo "busca: $try \n";
            $buscas[$try]=1;
                        } 
        set_time_limit(10); 
        } 
		
				foreach ($buscas as $busco => $value) {
				//echo '| ' . $busco . " |\n";	
				$matches = substr_count(" $str "," $busco "); 
				if ($matches >= $minfreq) 
				{$seqs[$busco] = $matches; } 
				}
		
set_time_limit(30); 
$finish = microtime(true); 

 
arsort($seqs); 



foreach ($seqs as $key => $value) {$npal=array();
$npal=explode(' ',$key);$np=count($npal);



$key2=urlencode($key);
if($np > 4){echo "|$key2|: $np \n";};		
if(!in_array($key, $excludes[$np])){
$result['w'][$np][$key]=$value;	
}	
}


foreach ($result['w'] as $np => $values) {
$totnp=count($values);
//if($totnp>100){$totnp=100;}	
foreach ($values as $pal => $itms) {
$result2['w'][$np][($pal)]=($itms/$totnp)*100;	
}	
	
}


  
return $result2;
  
}	 


function getCURScategorizados($idc){global $v;
$listcur="";	
$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cat=$idc;");	
foreach ($res as $key => $data) {$listcur.=$data['id_cur'] . ",";};
$listcur=substr($listcur, 0,-1);
return $listcur;	
}



function getCURtotcat($idc){global $v; global $pesos;
$str=utf8_encode(limpiaStr($v['where']['pagTittleSimp'])); 
$idp=$v['where']['idp'];


######### si esta cacheado aqui debo recuperar de la cache
#####  $v['where']['cats_inf_otras'] , $listcur, $v['palmatch']

if($v['debugIN']>0){$v['where']['cacheQ']=0;}

if($v['where']['cacheQ']>0){

$cache=search_STR($idp,$str); 
if($cache['c']==1){
$dvals=json_decode($cache['cache'],TRUE);	
}else{
$dvals=engine_CAT($idc,$str,$idp);
insert_STR($idp,$idc,$str,json_encode($dvals));
}

}else{
$dvals=engine_CAT($idc,$str,$idp);	
}



$listcur=$dvals['listcur'];
$v['where']['cats_inf_otras']=$dvals['mtem'];
$v['palmatch']=$dvals['pmatch'];
$pesos=$dvals['pesos'];


return $listcur;	
	
}



function getCURtotQUERY($str,$idp){global $v; global $pesos;

######### si esta cacheado aqui debo recuperar de la cache
#####  $v['where']['cats_inf_otras'] , $listcur, $v['palmatch']

if($v['debugIN']>0){$v['where']['cacheQ']=0;}
$cache=search_STR($idp,$str);
if(($cache['c']==1)&&($v['where']['cacheQ']>0)){
$dvals=json_decode($cache['cache'],TRUE);	
}else{ 
$dvals=engine_CAT(0,$str,$idp);
insert_STR($idp,0,$str,json_encode($dvals));
}




$listcur=$dvals['listcur'];
$v['where']['cats_inf_otras']=$dvals['mtem'];
$v['palmatch']=$dvals['pmatch'];
$pesos=$dvals['pesos'];


return $listcur;	
	
}














function engine_CAT($idc,$str,$idp){
global $v; global $pesos; global $ctinf;	

if($idc>0){
$str=addPalstoSTR($idc,$str,$idp); ### añado mas pals a str
}

$listcurA=array();

		###############################  sacadas de engine
		
		$listcurA=searchCUR($str,$idp,0,$idc); //busco str definitivo 
		
		if(!is_array($listcurA)){$listcurA=array();};

	 
		$maxP=reset($listcurA);
		###################################################
		
		############ añado categorizadas ???? necesario ????
		if($idc>0){
		$listcurB=explode(',',trim(getCURScategorizados($idc))); 
		foreach ($listcurB as $ii => $idcc) {
			if(array_key_exists($idcc, $listcurA)){$listcurA[$idcc]=$listcurA[$idcc]+300;}else{$listcurA[$idcc]=300;}	
		$minp=$listcurA[$idcc];
		}}else{$minp=20;}
		#####################################

		//$limite=$maxP; 
		//if($limite>300){$limite=80;}
		//if($limite<0){$limite=10;}
		
		$limite=$v['conf']['limitENGINE'];
		if($idc==0){$limite=20;};
																					if($v['debugIN']>0){
																					$v['dbi'].=  "<br>$minp - $maxP -> limite:$limite";	
																					}

		arsort($listcurA);
		
			        ################################################# creacion de lista definitiva
					$listcur="";$pesos=array();$ottCAT=array(); 
					$ctinf[$idc]=1;#añado la propia categoria a inferiores;
					
					foreach ($listcurA as $keyLL => $peso) {if($peso>=$limite){
								
					################ tematicas relacionadas	--- categorias q no estan en cats inferiores	
						if($keyLL){
						$ot=DBselect("SELECT id_cat FROM skv_relCurCats WHERE id_cur=$keyLL;");
						if(array_key_exists(1, $ot)){
							$idotC=$ot[1]['id_cat'];	
							if(!array_key_exists($idotC, $ctinf)){
								if(array_key_exists($idotC, $ottCAT)){ $ottCAT[$idotC]=$ottCAT[$idotC]+1; }else{ $ottCAT[$idotC]=1; }
						}}}
					###########################################
					
					if($keyLL){	
					$listcur.="$keyLL,";
					}
					$pesos[$keyLL]=$peso;		
					}}
					
						
					$listcur=substr($listcur, 0,-1);	
					#################################################################################




						#########################################################  creo array tematicas relacionadas
						$lcatsT="";arsort($ottCAT);$OT=0;$MOT=5;if($v['debugIN']>0){$MOT=999;}
						if(count($ottCAT)>0){
						foreach ($ottCAT as $idc => $qty) {if($OT<=$MOT){if($qty>0){$lcatsT .=$idc . ",";};$OT++;}}; 
						$lcatsT=substr($lcatsT, 0,-1);
						
						$dcats=array();
						if($lcatsT){
						$dcats=$catsPort=DBselect("select * from skf_urls where t_id IN ($lcatsT) AND idp=$idp AND tipo=1 ORDER BY pagTittleC;");
						}
						if(count($dcats)==0){$dcats=array();};
						}else{
						$dcats=array();	
						}
						
						$v['where']['cats_inf_otras']=$dcats;
						############################################################################################

##################
##################
###zona cacheable
################# almaceno en cache ->  $v['where']['cats_inf_otras'] , $listcur
$cache['mtem']=$v['where']['cats_inf_otras']; 
$cache['listcur']=$listcur;
$cache['pmatch']=$v['palmatch'];
$cache['pesos']=$pesos;

return $cache;	
}



function getCURcat($idc){
$tiempo_inicio = microtime(true);
global $v; global $pesos; global $ctinf;

$cpp=$v['conf']['cpp'];
$pag=$v['where']['pag'];

############### obtengo la lista total de cursos sin filtrar ni ordenar;
$listcur=getCURtotcat($idc);
#######################################################################

############## filtros metodos lugares
$cursF	=filtraCURS($listcur);
$listcur=$cursF['l'];
$nc		=$cursF['nc'];
#####################################



############## Ordeno resultados
$ini=(($pag-1)*$cpp);
$fin=($ini+$cpp)-1;
if($v['debugIN']>0){$fin=$nc;};
$curs=ordenaCURsNEW($listcur,$ini,$fin);


$listcur="";
foreach ($curs as $kk => $id) {$listcur.="$id,";}$listcur=substr($listcur, 0,-1);
################################


																					if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\n<br>\nfiltros en getCURcat:<br>\n";
																					$v['dbi'].=json_encode($v['subs']);}

$tiempo_fin = microtime(true);
																					if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\nTime getCURcat: " . ($tiempo_fin - $tiempo_inicio) . "<br>\n";
																					}


return $listcur;  #### retorna la lista filtrada paginada y ordenada separada por comas	
}








function filtraCURS($listcur){global $v;
$nc=0;

############## filtros metodos lugares
$idc=$v['where']['id'];
$idt=$v['where']['idt'];
$cpp=$v['conf']['cpp'];
$pag=$v['where']['pag'];
$idpro=$v['where']['id_provi'];
$online=$v['where']['online'];
$distancia=$v['where']['distancia'];


$ini=(($pag-1)*$cpp);
$fin=($ini+$cpp)-1;	



	#####################333## si hay resultados los filtro si es necesario	
		if($listcur){
		
		$v['subs']['spr']=array();	
		$v['subs']['pre']=0;	
		$v['subs']['dis']=0;
		$v['subs']['onl']=0;
		######### cuento variaciones antes de aplicar filtros;	
		$var=DBselect("SELECT id_metodo , count(distinct id_cur) as c FROM skv_relCurCats WHERE showC=1 AND id_cur IN ($listcur) group by id_metodo;");	
		if(count($var)>0){foreach ($var as $kkk => $vvv){$idmet=$vvv['id_metodo']; $num=$vvv['c'];
		$met="pre";if($idmet==4){$met="dis";};if($idmet==5){$met="onl";}
		$v['subs'][$met]=$v['subs'][$met]+$num;
		}}	
		
		
		#### provincias donde
		if($v['subs']['pre']){
			
		$var=DBselect("SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cur IN ($listcur) AND id_metodo != 5 AND id_metodo !=4;");	
		$listcurP="";
		if(count($var)>0){foreach ($var as $kkk => $vvv){$iidddccc=$vvv['id_cur'];
		$listcurP.="$iidddccc,";
		}}		
		$listcurP=substr($listcurP, 0,-1);	
		
		if($listcurP){
		$var=DBselect("SELECT count(distinct idcur) as c, idpro FROM skv_relCurPro WHERE idcur IN ($listcurP) GROUP BY idpro;");
		if(count($var)>0){foreach ($var as $kkk => $vvv){
				
			$idprov=substr($vvv['idpro'],0,3); $num=$vvv['c'];
			if(strlen($idprov)==2){$idprov="0" . $idprov;}
			if(($idprov=='070')||($idprov=='077')||($idprov=='078')){}else{$idprov=substr($idprov, 0,2);};	
			if(strlen($idprov)==2){$idprov=$idprov . "0";}
		
		//var_dump($idprov);
		
		if(array_key_exists($idprov,$v['subs']['spr'])){
		$v['subs']['spr'][$idprov]=$v['subs']['spr'][$idprov]+$num;	
		}else{
		$v['subs']['spr'][$idprov]=$num;	
		}
		}}	
		}
		
		}
		
		//print_r($v['subs']);
		
		
		############# añado filtro online o a distancia
		
			if($online){
			$onl="AND id_metodo=5";	
			}elseif($distancia){
			$onl="AND id_metodo=4";	
			}else{
					
				if($idpro){
				$onl="AND id_metodo != 5 AND id_metodo !=4";
				}else{
				$onl="";
				}		
			}
		
			
		//echo "SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cur IN ($listcur) AND id_tipo IN ($idt) $onl; \n";
		$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cur IN ($listcur) AND id_tipo IN ($idt) $onl;");	
		
		$listcur="";$nc=0;
		foreach ($res as $key => $data) {$listcur.=$data['id_cur'] . ",";$nc++;};
		$listcur=substr($listcur, 0,-1);		
		
		
		########## filtro provincias
		if($idpro){
		if(($idpro=='070')||($idpro=='077')||($idpro=='078')){}else{$idpro=substr($idpro, 0,2);};	
		
		//echo "SELECT distinct(idcur) FROM skv_relCurPro WHERE idpro like '$idpro%'  AND idcur IN ($listcur); \n";		
		$res=DBselect("SELECT distinct(idcur) as iddcc FROM skv_relCurPro WHERE idpro like '$idpro%'  AND idcur IN ($listcur);");
		$listcur="";$nc=0;	
		foreach ($res as $key => $datas) {$listcur.=$datas['iddcc'] . ",";$nc++;}
		$listcur=substr($listcur, 0,-1);	
		}
		###########
		
				
			
		}


$v['where']['npags']=ceil($nc/$cpp);

$res2['l']=$listcur;
$res2['nc']=$nc;
return $res2;
}




function palNO($str){

//$str=str_replace('gestion','',$str);
return $str;	
}






function addPalstoSTR($idc,$str,$idp){
$tiempo_inicio = microtime(true);	global $v;
//$str=utf8_encode($str);
$list=array();$lis="";
$str=limpiaStr($str);		

/*		
#### palbras negativas	
$str=palNO($str);
######################
*/	
	


	
	
	######## incluyo otras kw
		$lis="";
		$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cat=$idc;");	
		if(count($res)>0){foreach ($res as $key => $data) {$lis.=$data['id_cur'] . ",";}};
		$lis=substr($lis, 0,-1);
			
		
		
		$Lkeys=array();
		if($lis){
			$dcu=DBselectSDB("SELECT cur_palclave from skv_cursos WHERE id IN ($lis);",'seekformacion');
			if(array_key_exists(1, $dcu)){ foreach ($dcu as $idk => $value) {
				$keys=limpiaStr(($dcu[$idk]['cur_palclave']));	
				foreach (explode(' ',$keys) as $ii => $kk) {
				
				if(array_key_exists($kk, $Lkeys)){$Lkeys[$kk]++;}else{$Lkeys[$kk]=1;}
			}}}
		
		
		
		
		arsort($Lkeys);
		//print_r($Lkeys);
		$num=count($Lkeys); //echo $num;
		foreach ($Lkeys as $keyw => $i) {if($i>$num){
		$str .=" $keyw";	
		}}
	}
	########################
//print_r($Lkeys);
 

																					if($v['debugIN']>0){
																					$v['dbi'].= "<br>\n<br>\nSTR en SC:<br>\n";
																					$v['dbi'].=json_encode($str);}




$tiempo_fin = microtime(true);

																					if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\nTime searchCUR: " . ($tiempo_fin - $tiempo_inicio) . "<br>\n";
																					}


return $str;
}






function searchCUR($str,$idp,$paso,$idc){
$tiempo_inicio = microtime(true);
global $v;

//$str=utf8_encode($str);
//print_r($str);

$bus=phraseC($str,1,2,1,3);

  																	                if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\n<br>\nPAL bsco bus['w'] en SC2:<br>\n";
																					$v['dbi'].=json_encode($bus['w']);}


//print_r($bus['w']);
$res=array(); $palMatch=array();
foreach ($bus['w'] as $numpals => $pals) {foreach ($pals as $keywd => $pes){

	$keywd=utf8_encode($keywd);
	$keyw=base_convert(md5($keywd),16,11); $subKeyw=substr("$keyw",0,3);		
	
	
	$dcu=DBselectSDB("SELECT t_id, peso from md5_$subKeyw WHERE md5='$keyw' AND idp=$idp AND tipo=2 GROUP BY t_id;",'seek_engine_' . $numpals); 
	if(count($dcu)>0){foreach($dcu as $kk => $datos ){$id=$datos['t_id']; $peso=$datos['peso']*($numpals/2); 
		if(array_key_exists($id, $res)){$res[$id]=$res[$id]+$peso;}else{$res[$id]=$peso;}
		if(array_key_exists($keywd, $palMatch)){$palMatch[$keywd]=$palMatch[$keywd]+$peso;}else{$palMatch[$keywd]=$peso;}
	}}




######### disminuyo antonimos
$dcuNO=DBselectSDB("SELECT ant from antonimos WHERE pal='$keywd';",'seek_keys');
if(array_key_exists(1, $dcuNO)){
																			if($v['debugIN']>0){
								                                            $v['dbi'].=  "\n\nPALS RESTO en SC2:\n";}
       
	 foreach ($dcuNO as $kk => $vkno){
			
			$kwr=utf8_decode($vkno['ant']);
			$numpalsA=count(explode(' ',$kwr));
			$keyw=base_convert(md5($kwr),16,11);$subKeyw=substr("$keyw",0,3);
			$dcu=DBselectSDB("SELECT t_id, peso  from md5_$subKeyw WHERE md5='$keyw' AND idp=$idp AND tipo=2 GROUP BY t_id;",'seek_engine_' . $numpalsA); 
			if(count($dcu)>0){																	
			foreach($dcu as $kk => $datos ){$id=$datos['t_id']; $peso=$datos['peso']*($numpalsA/2); 
			if(array_key_exists($id, $res)){$res[$id]=$res[$id]-($peso*20);}else{$res[$id]=-($peso*20);};
			}
			if($v['debugIN']>0){
			$v['dbi'].=  "_______________\nresto \t$numpalsA $kwr \t\t\t\t $keyw \t   <---- (-)\n";
			}}
		}
	
	$keyw=base_convert(md5($keywd),16,11); $subKeyw=substr("$keyw",0,3); 								
	$dcu=DBselectSDB("SELECT t_id, peso  from md5_$subKeyw WHERE md5='$keyw' AND idp=$idp AND tipo=2 GROUP BY t_id;",'seek_engine_' . $numpals); 
	if(count($dcu)>0){foreach($dcu as $kk => $datos ){$id=$datos['t_id']; $peso=$datos['peso']*($numpals/2); 
	if(array_key_exists($id, $res)){$res[$id]=$res[$id]+($peso*1);}else{$res[$id]=($peso*1);}
	}		
	if($v['debugIN']>0){
	$v['dbi'].=  "\npongo \t$numpals $keywd \t\t\t\t $keyw \t   <---- (-)\n";	
	}}

}
#################################
}}


					######## parte a revisar
					######### creacion de palabras clave para strong
					arsort($palMatch);$v['palmatch']=$palMatch;
																					if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\n<br>\npalMatch:<br>\n";
																					$v['dbi'].= json_encode($palMatch);}
					global $pals; ###### lo cacheamos????
					$pals=array();
					$resK=DBselect("SELECT id, keyword FROM skf_cat_keywords WHERE id_cat=$idc ORDER BY CHAR_LENGTH(keyword) DESC;");	
					foreach ($resK as $key => $data) {
					$v['palmatch'][$data['keyword']]=1;	
					}			
					foreach ($v['palmatch'] as $key => $data) {
					$v['palmatch'][$key]=strlen($key);	
					}		
					arsort($v['palmatch']);
					foreach ($v['palmatch'] as $key => $value) {
					$pals[]=$key;	
					}
						
					//print_r($pals);
					###############################################3



$pesos=array();
global $pesos;
arsort($res);

$lista="";$a=0;
foreach ($res as $idbus => $peso) {
$pesos[$idbus]=$peso; 
//$lista.="$idbus,";  	 
}

$lista=substr($lista, 0,-1);
 
 

$tiempo_fin = microtime(true);
																			if($v['debugIN']>0){
																			$v['dbi'].=  "<br>\nTime searchCUR2: " . ($tiempo_fin - $tiempo_inicio) . "<br>\n";
																			}

return $pesos; 
}





?>