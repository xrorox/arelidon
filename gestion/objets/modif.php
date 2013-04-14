<?php
/*
 * Created on 12 sept. 2009
 *


 */
echo '<div>';
echo '<form id="form_item" method="post" action="panneauAdmin.php?category=11&update=1&iditem='.$_GET['iditem'].'">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('id','image','nom','classe','level','poid','prix','rarity','magasin');
		$caracts = getCaractList('1','1');
		foreach($caracts as $caract)
		{
			$arrayStatut[] = $caract;
		}
		
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
			if($row != 'image')
				$onclick = "HTTPTargetCall('$urltri','tdbodygame')";
			else
				$onclick = '';
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$row.' </td>';
		}
		echo '<td> </td>';
	echo '</tr>';
	$sql = "SELECT * FROM objet WHERE id = ".$_GET['iditem'];
	$item = loadSqlResultArray($sql);
	
	echo '<tr>';		
		echo '<td>'.$item['id'].'</td>';
		echo '<td>';
			echo '<img src="pictures/item/'.$item['id'].'.gif" alt="Absent" />';
		echo '</td>';
		echo '<td><input type="text" name="name" value="'.$item['name'].'" size="16" /></td>';
		// classe d'objet
		echo '<td>';
			echo '<select name="typeitem">';
				$arrayItemTypes = getAllItemTypes();
				foreach($arrayItemTypes as $key=>$value)
				{
					echo '<option value="'.$key.'" ';
					if($key == $item['typeitem'])
						echo 'SELECTED=SELECTED';
					echo '>'.$value.'</option>';
				}
			echo '</select>';
		echo '</td>';
		echo '<td><input type="text" name="level" value="'.$item['level'].'" size="2" /></td>';
		echo '<td><input type="text" name="poid" value="'.$item['poid'].'" size="3" /></td>';
		echo '<td><input type="text" name="price" value="'.$item['price'].'" size="3" /></td>';
		echo '<td><input type="text" name="rarity" value="'.$item['rarity'].'" size="3" /></td>';
		echo '<td><input type="text" name="magasin" value="'.$item['magasin'].'" size="3" /></td>';
		$caracts = getCaractList('1','1');
		foreach($caracts as $caract)
		{
			echo '<td><input type="text" name="'.$caract.'" value="'.$item[$caract].'" size="2" /></td>';
		}
		
		echo '<td> <input class="button" type="submit" value="OK" onclick=""></td>';
	echo '</tr>';
echo '</table>';
echo '</form>';
echo '</div><br /><br />';
?>
