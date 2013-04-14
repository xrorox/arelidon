<?php
/*
 * Created on 12 sept. 2009
 *
 */
 
echo '<div>';
echo '<form id="form_monster" method="post" action="panneauAdmin.php?category=5&update=1&idmonster='.$_GET['idmonster'].'">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('id','image','taille','nom','level','exp','6'=>'range_min','7'=>'range_max','8'=>'timerespawn');
		
		
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
			if($row == "timerespawn")
				$row = 'respawn';
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$row.' </td>';
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
	
	$sql = "SELECT * FROM monster WHERE id = ".$_GET['idmonster'];
	$monster = loadSqlResultArray($sql);
	
	echo '<tr>';		
		echo '<td>'.$monster['id'].'</td>';
		echo '<td>';
			echo '<img src="pictures/monster/'.$monster['id'].'.gif" alt="Absent" />';
		echo '</td>';
		echo '<td>';
			echo '<select name="taille" id="taille" onchange="changeTelep(\'taille\');" style="background:url(pictures/taille/'.$monster['taille'].'.gif) no-repeat; width:50px; height:38px;">';
				for($i=1;$i<=4;$i++)
				{
					switch($i)
					{
						case '1':
							$width='32';
							$height='32';
						break;
						
						case '2':
							$width='32';
							$height='64';
						break;
						
						case '3':
							$width='64';
							$height='32';
						break;
						
						case '4':
							$width='64';
							$height='64';
						break;
					}
					echo '<option value="'.$i.'" style="background:url(pictures/taille/'.$i.'.gif) no-repeat; width:'.$width.'px; height:'.$height.'px;" ';
					if($monster['taille'] == $i)
							echo 'SELECTED=selected';
					echo '></option>';
				}
			echo '</select>';
		echo '</td>';
		echo '<td><input type="text" name="nom" value="'.$monster['nom'].'" size="12" /></td>';
		echo '<td><input type="text" name="level" value="'.$monster['level'].'" size="3" /></td>';
		echo '<td><input type="text" name="exp" value="'.$monster['exp'].'" size="3" /></td>';
		echo '<td><input type="text" name="range_min" value="'.$monster['range_min'].'" size="3" /></td>';
		echo '<td><input type="text" name="range_max" value="'.$monster['range_max'].'" size="3" /></td>';
		echo '<td><input type="text" name="timerespawn" value="'.$monster['timerespawn'].'" size="3" /></td>';
		
		$caracts = getCaractList('0','0');
		foreach($caracts as $caract)
		{
			echo '<td><input type="text" name="'.$caract.'" value="'.$monster[$caract].'" size="3" /></td>';
		}
		
		echo '<td> <input class="button" type="submit" value="Modifier" onclick=""></td>';
	echo '</tr>';
echo '</table>';
echo '<div>';
	echo 'autres modif';
echo '</div>'; 

echo '<div> attaque : ';
$skillArray = skill::getAllSkill();
	echo '<select name="id" >';
		foreach($skillArray as $skill)
		{
			echo '<option value="'.$skill['id'].'" ';
			// ici auto select attaque prédéfinie
			echo '>'.$skill['name'].'</option>';
		}
	echo '</select>';
echo '</div>';
echo '</form>';
echo '</div><br /><br />';
?>
