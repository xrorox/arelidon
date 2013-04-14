<?php
/*
 * Created on 5 mars 2010
 */
 
echo '<div>';
echo '<form id="form_item" method="post" action="panneauAdmin.php?category=13&update=1&tresor_id='.$_GET['tresor_id'].'">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('id','map','abs','ord','nbobjet','objet','gold','typecle','cle','');

		foreach($arrayStatut as $row)
		{
			$urltri = "gestion/page.php?category=5&orderby=";
			if($orderby == $row && $asc == 'ASC')
			{
				$asca = 'DESC';
			}elseif($orderby == $row && $asc == 'DESC'){
				$asca = 'ASC';
			}
			$urltri = $urltri.$row.'&asc='.$asca;

			echo '<td onclick="" style="cursor:pointer;">'.$row.' </td>';
		}
		echo '<td> </td>';
	echo '</tr>';
	
	
	$box = new box($_GET['tresor_id']);
	echo '<tr>';		
		echo '<td>'.$box->getId().'</td>';
		
		echo '<td><input type="text" name="map" value="'.$box->getMap().'" size="3" /></td>';
		echo '<td><input type="text" name="abs" value="'.$box->getAbs().'" size="3" /></td>';
		echo '<td><input type="text" name="ord" value="'.$box->getOrd().'" size="3" /></td>';
		
		echo '<td><input type="text" name="nbobjet" value="'.$box->getNbObjet().'" size="3" /></td>';
		
		$array_ob = getAutocomplete('item');
		$objet = new item($box->getObjet());
		$objet_value = $objet->getName();
		echo '<td><input id="objet_gagne" value="'.$objet_value.'" onfocus="autoComplete(\'objet_gagne\',\''.$array_ob.'\');autoComplete(\'objet_gagne\',\''.$array_ob.'\');" type="text" name="objet"  size="20"></td>';

		echo '<td><input type="text" name="gold" value="'.$box->getGold().'" size="3" /></td>';
		
		echo '<td><input type="text" name="typecle" value="'.$box->getTypeCle().'" size="3" /></td>';
		$cle = new item($box->getCle());
		$cle_value = $cle->getName();
		echo '<td><input id="cle" value="'.$cle_value.'" onfocus="autoComplete(\'cle\',\''.$array_ob.'\');autoComplete(\'cle\',\''.$array_ob.'\');" type="text" name="cle"  size="20"></td>';
		
		echo '<td> <input class="button" type="submit" value="OK" onclick=""></td>';
	echo '</tr>';
echo '</table>';
echo '</form>';
echo '</div><br /><br />';
?>
