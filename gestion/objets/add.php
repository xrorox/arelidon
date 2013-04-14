<?php
/*
 * Created on 12 sept. 2009
 *


 */
 
echo '<form id="form_item" method="post" action="panneauAdmin.php?category=11&add=1&iditem='.$_GET['iditem'].'">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('id','nom','classe','level','poid','prix','rarity','magasin');
		$caracts = getCaractList('1','1');
		foreach($caracts as $caract)
		{
			$arrayStatut[] = $caract;
		}
		
		foreach($arrayStatut as $row)
		{
			$urltri = "gestion/page.php?category=11&orderby=";
			if($orderby == $row && $asc == 'ASC')
			{
				$asca = 'DESC';
			}elseif($orderby == $row && $asc == 'DESC'){
				$asca = 'ASC';
			}
			$urltri = $urltri.$row.'&asc='.$asca;
			if($row != 'image')
				$onclick = "HTTPTargetCall('$urltri','tdbodygame')";
			else
				$onclick = '';
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$row.' </td>';
		}
		
		echo '<td> Ajouter </td>';
	echo '</tr>';
	
	echo '<tr>';		
		echo '<td> # </td>';
		echo '<td><input type="text" name="nom" value="" size="12" maxlength="35" /></td>';
				// classe d'objet
		echo '<td>';
			echo '<select name="typeitem">';
				$arrayItemTypes = getAllItemTypes();
				foreach($arrayItemTypes as $key=>$value)
				{
					echo '<option value="'.$key.'" ';
					echo '>'.$value.'</option>';
				}
			echo '</select>';
		echo '</td>';
		echo '<td><input type="text" name="level" value="1" size="2" /></td>';
		echo '<td><input type="text" name="poid" value="1" size="3" /></td>';
		echo '<td><input type="text" name="price" value="0" size="3" /></td>';
		echo '<td><input type="text" name="rarity" value="0" size="3" /></td>';
		echo '<td><input type="text" name="magasin" value="0" size="3" /></td>';
		$caracts = getCaractList('1','1');
		foreach($caracts as $caract)
		{
			echo '<td><input type="text" name="'.$caract.'" value="0" size="2"></td>';
		}
		
		echo '<td> <input class="button" type="submit" value="Ajouter" onclick=""></td>';
	echo '</tr>';
echo '</table>';
echo '</form><br />';
?>

