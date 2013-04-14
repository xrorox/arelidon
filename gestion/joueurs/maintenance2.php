<?php
require_once('../../require.php');

$sql= "SELECT DISTINCT donjon_group FROM `monsteronmap` ";
$arrayofarray = loadSqlResultArrayList($sql);
echo ' <table>';

foreach($arrayofarray as $array){
	
	
	$sql="SELECT * FROM `map2` WHERE map=".$array['id'];
	$arrayresult=loadSqlResultArrayList($sql);
	
	foreach($arrayresult as $result){
		$sql="INSERT INTO `map` SET map=".$result['map'].",abs=".$result['abs'].",ord=".$result['ord'].",bloc=".$result['bloc'].",changemap=".$result['changemap'].",abschange=".$result['abschange'].",ordchange=".$result['ordchange'].",`type`=".$result['type'];
		loadSqlExecute($sql);
	}
	
}
echo "C'est bon'";
echo '</table>';



		?>
