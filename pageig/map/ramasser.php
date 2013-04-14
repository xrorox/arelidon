<?php
/*
 * Created on 8 nov. 2009
 */
 
 // Vérification que le joueur est sur la même case que l'objet
 
$item = new item($_GET['item_ramasse']);

if(calculDistance($char->getAbs(),$char->getOrd(),$_GET['abs_char'],$_GET['ord_char'],1) <= 1)
{
	$sql = "SELECT count(*) FROM `objetonmap` WHERE map = ".$char->getMap()." && abs = ".$_GET['abs_char']." && ord = ".$_GET['ord_char']." && item_id = $item->item LIMIT 1 ";
	$result=loadSqlResult($sql);
	if($result>=1){
		$item->addItemToChar($char->getId());
	
		$sql = "DELETE FROM `objetonmap` WHERE map = ".$char->getMap()." && abs = ".$_GET['abs_char']." && ord = ".$_GET['ord_char']." && item_id = $item->item LIMIT 1 ";
		loadSqlExecute($sql);
	
		echo '<div style="margin-top:5px;padding-left:5px;">';
		echo 'Vous ramassez '.$item->name;
	echo '</div>';
	}
}else{
	echo '<div style="margin-top:5px;padding-left:5px;">';
		echo 'Vous &ecirc;tes trop loin';
	echo '</div>'; 
}
?>
