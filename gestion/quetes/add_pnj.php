<?php
/*
 * Created on 30 sept. 2009
 *
 * Ajouter un PNJ
 */

echo '<hr />';

echo '<form id="form_monster" enctype="multipart/form-data" method="post" action="panneauAdmin.php?category=16&add=1">';
echo '<table><tr>';

echo '<td>';
// Image du pnj sur la carte	
	echo '<div>';
		echo 'Image sur la carte ';
	echo '</div><div>';
		echo '<input type="file" name="image" />';
	echo '</div>';
// Fonction du PNJ	
	echo '<div>';
		echo 'Fonction ';
	echo '</div><div>';
		pnj::getSelectFonction();
	echo '</div>';
	
echo '</td>';
echo '<td>';
	echo '<div>';
		echo 'Image du visage ';
	echo '</div><div>';
		echo '<input type="file" name="face" />';
	echo '</div>';
// id du magasin	
	echo '<div>';
		echo 'fonction name (si besoin) ';
	echo '</div><div>';
		$array = getAutocomplete('shop');
		echo '<input id="fonction_id" type="text" name="fonction_id" onclick="autoComplete(\'fonction_id\',\''.$array.'\');autoComplete(\'fonction_id\',\''.$array.'\');" />';
	echo '</div>';
echo '</td>';


echo '<td>';
echo '<div style="margin-left:30px;">';
	echo 'Texte du PNJ (dans le cas o&ugrave; il n\'a pas de qu&ecirc;te) ';
echo '</div>';

'<div style="margin-left:50px;">';
	echo '<textarea name="textpnj" length="50" row="2">';
	
	echo '</textarea>';
echo '</div>';
echo '</td>';

echo '</tr></table>';
echo '<table border="1" class="backgroundBody" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenu">';
		$arrayStatut = array('id','name','titre','taille','map','abs','ord');
			
		foreach($arrayStatut as $row)
		{
			echo '<td onclick="">'.$row.' </td>';
		}
		
		
		echo '<td> Modifier </td>';
	echo '</tr>';
	
	echo '<tr>';		
		echo '<td> # </td>';
		echo '<td><input type="text" name="name" value="" size="12" /></td>';
		echo '<td><input type="text" name="title" value="" size="12" /></td>';
		echo '<td><input type="text" name="taille" value="" size="3" /></td>';
		echo '<td><input type="text" name="map" value="" size="3" /></td>';
		echo '<td><input type="text" name="abs" value="" size="3" /></td>';
		echo '<td><input type="text" name="ord" value="" size="3" /></td>';	
		
		echo '<td> <input type="submit" class="button" value="Ajouter" onclick=""></td>';
	echo '</tr>';
echo '</table>';

echo '</form><br />';
echo '<hr />';
?>


