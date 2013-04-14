<?php
/*
 * Created on 13 déc. 2009
 *
 */
 
echo '<div>';
	echo '<div  style="float:left;margin-left:40px;">';
		echo 'Liste des monstres : <br />';
		echo '<div style="width:250px;min-height:500px;background:white;margin-top:5px;border:solid 1px grey;">';
			$array_monster = monster::getAllMonsterObject();
			$i = 0;
			foreach($array_monster as $monster)
			{
				$url = "gestion/page.php?category=31&action=edit&monster_id=".$monster->idmstr;
				$onclick = "HTTPTargetCall('$url','monster_skill_container');";
				echo '<img src="pictures/monster/'.$monster->idmstr.'.gif" alt="image manquante '.$monster->idmstr.'.gif" title="'.$monster->getName().'" onclick="'.$onclick.'" />';
				
				$i++;
				if($i = 5)
					$i = 0;
			}
		echo '</div>';
	echo '</div>'; 
	
	echo '<div id="monster_skill_container" style="float:left;margin-left:20px;">';
			
	echo '</div>'; 

echo '</div>'; 
?>
