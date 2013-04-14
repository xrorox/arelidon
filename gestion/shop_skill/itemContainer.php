<?php
/*
 * Created on 20 oct. 2009
 *
 */
if($shop->id == 0)
	$shop = new shop_skill($_GET['id']);

$url = "";
 	
// Récupération des données
if($_GET['min'] != '')
	$min = $_GET['min'];
else
 	$min = 0;
 	
if($_GET['max'] != '')
 	$max = $_GET['max'];
else
 	$max = 80;
 	
 	
 	$url = "gestion/page.php?category=29&action=itemContainer";
 	$div_id = "item_container";
	
	$url_target = "gestion/page.php?category=29&action=shopContainer&reload=1&add=1";
	$div_target = "shop_container";
	
	$content .= skill::getAllSkillInTable($url,$min,$max,$div_idn,$div_target,$url_target,$shop->id); 
?>
