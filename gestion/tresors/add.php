<?php
/*
 * Created on 5 mars 2010
 */
 
 
echo '<form id="form_item" method="post" action="panneauAdmin.php?category=13&add=1&tresor_id='.$_GET['iditem'].'">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('map','abs','ord','img','nbobjet','objet','gold','typecle','cle');

		foreach($arrayStatut as $row)
		{
			echo '<td onclick="" style="cursor:pointer;">'.$row.' </td>';
		}
		
		echo '<td> Ajouter </td>';
	echo '</tr>';
	
	echo '<tr>';		
		
		echo '<td><input type="text" name="map" value="" size="3" /></td>';
		echo '<td><input type="text" name="abs" value="" size="3" /></td>';
		echo '<td><input type="text" name="ord" value="" size="3" /></td>';
		
		echo '<td><input type="text" name="img" value="" size="3" /></td>';
		
		echo '<td><input type="text" name="nbobjet" value="1" size="3" /></td>';
		$array_ob = getAutocomplete('item');
		echo '<td><input id="objet_gagne" onfocus="autoComplete(\'objet_gagne\',\''.$array_ob.'\');autoComplete(\'objet_gagne\',\''.$array_ob.'\');" type="text" name="objet"  size="20"></td>';
		
		echo '<td><input type="text" name="gold" value="0" size="3" /></td>';
		
		echo '<td><input type="text" name="type_cle" value="0" size="3" /></td>';
		echo '<td><input id="cle" onfocus="autoComplete(\'cle\',\''.$array_ob.'\');autoComplete(\'cle\',\''.$array_ob.'\');" type="text" name="cle"  size="20"></td>';
		
		echo '<td> <input class="button" type="submit" value="Ajouter" onclick=""></td>';
	echo '</tr>';
echo '</table>';
echo '</form><br />'; 
?>
