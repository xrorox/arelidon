<?php
/*
 * Created on 19 oct. 2009
 *


 */
 
echo '<form id="form_shop" method="post" action="panneauAdmin.php?category=29&add=1">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('nom');

		foreach($arrayStatut as $row)
		{
			echo '<td onclick="" style="">'.$row.' </td>';
		}
		
		echo '<td> Ajouter </td>';
	echo '</tr>';
	
	echo '<tr style="height:40px;">';		
		echo '<td><input type="text" name="name" value="" size="75" /></td>';
		
		echo '<td> <input type="submit" value="Ajouter" onclick=""></td>';
	echo '</tr>';
echo '</table>';
echo '</form>';
?>

