<?php
/*
 * Created on 30 sept. 2009
 *
 * Modification d'un pnj
 */
echo '<div>';
echo '<form id="form_pnj" method="post" action="panneauAdmin.php?category=16&update=1&idpnj='.$_GET['idpnj'].'">';

$pnj = new pnj($_GET['idpnj']);


echo '<table><tr>';

echo '<td>';
// Image du pnj sur la carte	
	echo '<div>';
		echo 'Image sur la carte ';
	echo '</div><div>';
		echo '<input type="file" name="image" value="'.$pnj->image.'" />';
	echo '</div>';
// Fonction du PNJ	
	echo '<div>';
		echo 'Fonction ';
	echo '</div><div>';
		pnj::getSelectFonction($pnj->fonction);
	echo '</div>';
	
echo '</td>';
echo '<td>';
	echo '<div>';
		echo 'Image du visage ';
	echo '</div><div>';
		echo '<input type="file" name="face" value="'.$pnj->face.'" />';
	echo '</div>';
// id du magasin	
	echo '<div>';
		echo 'Magasin (si besoin) ';
	echo '</div><div>';
		
		$array = getAutocomplete('shop');
		if($pnj->fonction_id == 1)
		{
			$name_shop = shop::getNameById($pnj->fonction_id);		
		}else{
			$name_shop = shop_skill::getNameById($pnj->fonction_id);		
		}

		
		echo '<input id="fonction_id" value="'.$name_shop.'" type="text" name="fonction_id" onclick="autoComplete(\'fonction_id\',\''.$array.'\');autoComplete(\'fonction_id\',\''.$array.'\');" />';
	echo '</div>';
echo '</td>';


echo '<td>';
echo '<div style="margin-left:30px;">';
	echo 'Texte du PNJ (dans le cas o&ugrave; il n\'a pas de qu&ecirc;te) ';
echo '</div>';

'<div style="margin-left:50px;">';
	echo '<textarea name="textpnj" length="50" row="2">';
		echo $pnj->text;
	echo '</textarea>';
echo '</div>';
echo '</td>';

echo '</tr></table>';


echo '<table border="1" class="backgroundBody" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenu">';
		$arrayStatut = array('id','image','name','title','taille','map','abs','ord');
		
		
		foreach($arrayStatut as $row)
		{

			$onclick = '';
			echo '<td onclick="'.$onclick.'">'.$row.' </td>';
		}
		
		echo '<td> Modifier </td>';
	echo '</tr>';
	
	$sql = "SELECT * FROM pnj WHERE id = ".$_GET['idpnj'];
	$pnj = loadSqlResultArray($sql);
	
	echo '<tr>';		
		echo '<td>'.$pnj['id'].'</td>';
		echo '<td>';
			echo '<img src="pictures/pnj/'.$pnj['image'].'" alt="Absent" />';
		echo '</td>';
		echo '<td><input type="text" name="name" value="'.$pnj['name'].'" size="12" /></td>';
		echo '<td><input type="text" name="title" value="'.$pnj['title'].'" size="12" /></td>';
		echo '<td><input type="text" name="taille" value="'.$pnj['taille'].'" size="3" /></td>';
		echo '<td><input type="text" name="map" value="'.$pnj['map'].'" size="3" /></td>';
		echo '<td><input type="text" name="abs" value="'.$pnj['abs'].'" size="3" /></td>';
		echo '<td><input type="text" name="ord" value="'.$pnj['ord'].'" size="3" /></td>';
		
		echo '<td> <input type="submit" class="button" value="Modifier" onclick=""></td>';
	echo '</tr>';
echo '</table>';

echo '</form>';
echo '</div><br /><br />';
?>
