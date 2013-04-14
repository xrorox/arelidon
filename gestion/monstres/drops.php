<?php
/*
 * Created on 8 nov. 2009
 *
 * Gestion des drops 
 */
 
 
echo '<div>';
	echo '<div  style="float:left;margin-left:40px;">';
		echo 'Liste des monstres : <br />';
		echo '<div style="width:250px;min-height:500px;background:white;margin-top:5px;border:solid 1px grey;">';
			$array_monster = monster::getAllMonsterObject();
			$i = 0;
			foreach($array_monster as $monster)
			{
				$url = "gestion/page.php?category=7&action=edit&monster_id=".$monster->idmstr;
				$onclick = "HTTPTargetCall('$url','monster_drop_container');";
				echo '<img src="pictures/monster/'.$monster->idmstr.'.gif" alt="image manquante '.$monster->idmstr.'.gif" title="'.$monster->getName().'" onclick="'.$onclick.'" />';
				
				$i++;
				if($i = 5)
					$i = 0;
			}
		echo '</div>';
	echo '</div>'; 
	
	echo '<div id="monster_drop_container" style="float:left;margin-left:20px;">';
			
	echo '</div>'; 

echo '</div>'; 
 
?>
