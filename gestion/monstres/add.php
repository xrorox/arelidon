<?php
/*
 * Created on 12 sept. 2009
 */
 
echo '<form id="form_monster" method="post" action="panneauAdmin.php?category=5&add=1&idmonster='.$_GET['idmonster'].'">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('1'=>'id','2'=>'taille','3'=>'nom','4'=>'level','5'=>'exp','6'=>'range_min','7'=>'range_max','8'=>'timerespawn');
		
		
		foreach($arrayStatut as $row)
		{
			echo '<td onclick="" style="">'.$row.' </td>';
		}
		
		

		
		$caracts = getCaractList('0','0');
		foreach($caracts as $caract)
		{
			$urltri = "gestion/page.php?category=5&orderby=";
			if($orderby == $caract && $asc == 'ASC')
			{
				$asca = 'DESC';
			}elseif($orderby == $caract && $asc == 'DESC'){
				$asca = 'ASC';
			}
			$urltri = $urltri.$caract.'&asc='.$asca;
			
			$onclick = "HTTPTargetCall('$urltri','tdbodygame')";
				
			$show = $caract;
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$show.'</td>';
		 	}
		
		echo '<td> Modifier </td>';
	echo '</tr>';
	
	echo '<tr style="height:40px;">';		
		echo '<td> # </td>';
		echo '<td>';
			echo getSelectTailleForm($row['type']);
		echo '</td>';
		echo '<td><input type="text" name="nom" value="" size="12" /></td>';
		echo '<td><input type="text" name="level" value="" size="3" /></td>';
		echo '<td><input type="text" name="exp" value="" size="3" /></td>';
		echo '<td><input type="text" name="range_min" value="" size="3" /></td>';
		echo '<td><input type="text" name="range_max" value="" size="3" /></td>';
		echo '<td><input type="text" name="respawn" value="" size="3" /></td>';
		
		$caracts = getCaractList('0','0');
		foreach($caracts as $caract)
		{
			echo '<td><input type="text" name="'.$caract.'" value="" size="3"></td>';
		}
		
		echo '<td> <input type="submit" value="Ajouter" onclick=""></td>';
	echo '</tr>';
echo '</table>';
echo '</form>';
?>

