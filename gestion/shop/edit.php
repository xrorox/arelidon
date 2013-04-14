<?php
/*
 * Created on 20 oct. 2009
 *


 */
 
 require_once(absolutePathway().'/class/shop.class.php');
// A gauche , l'affichage du magasin et des objes qu'il contient
$shop = new shop($_GET['id']);


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
	$action = '<img src="pictures/icones/tonneau.gif" alt="X" /> Liste des objets sur le jeu';
	$checked[$_GET['type']]	= "checked=checked";
	?>
	<select onchange="gestionItem(this.value);"/>';
			<option value="20" <?php echo $checked[20]; ?>>Tous</option>
			<option value="1"<?php echo $checked[1]; ?>>&eacute;p&eacute;es</option>
			<option value="2"<?php echo $checked[2]; ?>>baguettes</option>
			<option value="3"<?php echo $checked[3]; ?>>boucliers</option>
			<option value="4"<?php echo $checked[4]; ?>>armurees</option>
			<option value="5"<?php echo $checked[5]; ?>>casques</option>
			<option value="6"<?php echo $checked[6]; ?>>ceintures</option>
			<option value="7"<?php echo $checked[7]; ?>>bottes</option>
			<option value="8"<?php echo $checked[8]; ?>>outils</option>
			<option value="9"<?php echo $checked[9]; ?>>arcs</option>
			<option value="10"<?php echo $checked[10]; ?>>batons</option>
			<option value="11"<?php echo $checked[11]; ?>>anneaux</option>
			<option value="12"<?php echo $checked[12]; ?>>gants</option>
			<option value="13"<?php echo $checked[13]; ?>>colliers</option>
			<option value="15"<?php echo $checked[15]; ?>>haches</option>
			<option value="999"<?php echo $checked[999]; ?>>potions</option>
			<option value="0"<?php echo $checked[0]; ?>>ressources</option>
	</select>
	<?php
	$icon = "pictures/icones/carte.gif";
	$width = "100%";
	
	$content = '<div id="item_container">';
		include('itemContainer.php');
	$content .= '</div>';

	createHTMLBox($title,$action,$icon,$content,$width); 


echo '</div>';

?>
