<?php

$target = "mapGestion";
$test=0;
$false=0;
foreach ($arrayWP as $arraytest){
if(($arraytest['ord'] == $ord) AND ($arraytest['abs'] == $abs)){

$valid_telep=$test;

	

	

}else{ // fin si changemap = 0 
		
$test=$test + 1;
	
} 
$false=$false+1;
}

if ($test < $false){
$url = "map=".$arrayWP[$valid_telep]['changemap'];
	$onclick = 'changeMapWithTelep(\''.$url.'\');';
	
	$type = $arrayWP[$valid_telep]['type'];
	if($type == 0)
		$type = 1;
	echo '<a href="#"><img src="pictures/telep/'.$type.'.png" border="0" onclick="'.$onclick.'"></a>';
}	
else{	

	map::showCaseBlock($case,$arrayBlock[$case],$abs,$ord,$target,$map->id,$arrayBlockex);
}

 ?>
