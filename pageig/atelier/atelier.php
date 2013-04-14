<?php
/*
 * Created on 6 mars 2010
 */
 require_once($server.'class/faction.class.php');
 require_once($server.'class/recette.class.php');
 $atelier = new atelier($_GET['id']);
 $outil_id = item::getEquipement($char->getId(),'hand');
 
 
 if($level_want != 0)
 	$level_want = $_POST['level'];
 
 if($nb_ingredient == 0)
 	$nb_ingredient = $_POST['nb_ingredient'];
 	 	
 	
 // Liste des objets que l'utilisateur pourra vendre
	echo '<div  style="float:left;margin-right:5px;margin-top:25px;margin-left:50px;">';
	
		echo '<div class="backgroundBody" style="width:650px;">';
		
			echo '<div class="backgroundMenu">';
				echo '<div style="margin-left:35px;">Atelier</div>';
			echo '</div>';
			
			echo '<div id="info_job" style="margin-top:10px;">';
			
			echo '</div>';
			
			echo '<form id="sort_craft" style="margin-left:5px;margin-top:10px;">';
				echo ' Nombre d\'ingr&eacute;dients :';
				echo '<select name="nb_ingredient">';
					echo '<option value="0">Tous</option>';
					for($i=1;$i<=5;$i++)
						echo '<option value="'.$i.'">'.$i.'</option>';
				echo '</select>';
				
				echo ' Niveau :';
				echo '<select name="level">';
					echo '<option value="0">Tous</option>';
					echo '<option value="5"> >5 </option>';
					echo '<option value="10"> >10 </option>';
					echo '<option value="15"> >15 </option>';
				echo '</select>';
				
				
				$url = "page.php?category=atelier&id=".$atelier->getId();
				$onclick = "HTTPPostCall('$url','sort_craft','bodygameig');cleanMenu();";
				echo ' <input class="button" type="button" onclick="'.$onclick.'" value="Trier" />';
			echo '</form>';
			
			echo '<div id="div_craft">';
			
			echo '</div>';
			
			echo '<hr />';
			
			echo '<div id="recette_container" style="height:170px;">';
			
				$metier = new metier(metier::getMetierIdByOutil($outil_id));
				$metier->loadMetierJoinChar($metier->getId(),$char->getId());
				
				$recettes = recette::getAllRecettes($metier->getId(),$metier->getLevel(),$nb_ingredient);
			
				echo '<table style="margin-left:70px;">';
				
				
				
				
				foreach($recettes as $recette_info)
				{
					echo '<tr>';
					$recette = new recette($recette_info['id']);
					
					$compte = 0;
					for($i=4;$i>=0;$i--)
					{
						if($recette->getNumberOfIngredient() >= ($i + 1))
						{
							echo '<td style="width:55px;text-align:center;">';
					
							if($compte >0)
								echo ' + ';
								
							$ingredient_array = $recette->getIngredientArray();
							$ingredient = new item($ingredient_array[$i]['objet']);
							
							echo $ingredient_array[$i]['nb_objet'];
							$ingredient->getPicture();
									
							echo '</td>';
					
					
							$compte++;
						}else{
							echo '<td style="width:50px;"></td>';
						}
						
					}
					
					echo '<td style="width:30px;text-align:center;"> = </td>';
					
					$objet_win = new item($recette->getObjetWin());
					echo '<td style="width:50px;">';
						echo $recette->getNbObjetWin();
						$objet_win->getPicture();
					echo '</td>';
				
					echo '<td>';
						$url = "page.php?category=atelier&action=do_craft&recette_id=".$recette->getId();
						$onclick = "HTTPTargetCall('".$url."','div_craft');";
						
						if($profil_metier == 0)
							echo '<input type="button" class="button" value="Fabriquer" onclick="'.$onclick.'" />';
					echo '</td>';
				}				
				echo '</tr>';

				echo '</table>';


			echo '</div>';
	
		echo '</div>';
	
		echo '<div></div>';
			$link = "ingame.php";
			createButton('Sortir',"",'exit',$link);
	
	echo '</div>';
?>
