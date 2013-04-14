<?php
/*
 * Created on 20 oct. 2009
 *


 */
 
require_once(absolutePathway().'class/shop_skill.class.php');
// A gauche , l'affichage du magasin et des objes qu'il contient
$shop = new shop_skill($_GET['id']);


echo '<div style="float:left;width:370px;margin-left:5px;">';
	
	$title = $shop->name;
	$title = htmlentities($title,ENT_QUOTES);
	$action = '<img src="pictures/icones/tonneau.gif" alt="X" /> Liste des objets dans le magasin';
	$icon = "pictures/icones/shop.gif";
	$width = "100%";
	
	$shop->loadItemCollection();
	
	if(count($shop->getItemCollection()) >= 1)
	{
		$content = '<div id="shop_container">';
		include('shopContainer.php');
		$content .= '</div>';	
	}else{
		$content = '<div id="shop_container">';
		$content .= "<img src=\"pictures/utils/alert.gif\" alt=\"Attention : \" /> Aucun objet dans ce magasin";
		$content .= '</div>';
	}
	
	
	createHTMLBox($title,$action,$icon,$content,$width);


echo '</div>';

echo '<div style="float:left;width:370px;margin-left:20px;">';
	
	$title = " Objet sur Arélidon";
	$title = htmlentities($title,ENT_QUOTES);
	$action = '<img src="pictures/icones/tonneau.gif" alt="X" /> Liste des sorts sur le jeu';
	$icon = "pictures/icones/carte.gif";
	$width = "100%";
	
	$content = '<div id="item_container">';
		include('itemContainer.php');
	$content .= '</div>';
	
	createHTMLBox($title,$action,$icon,$content,$width);


echo '</div>';

?>
